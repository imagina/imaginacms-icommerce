<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\OrderRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\OrderTransformer;

// Entities
use Modules\Icommerce\Entities\Order;

// Repositories
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\OrderHistoryRepository;
use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Icommerce\Repositories\CartRepository;
use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Icommerce\Repositories\StoreRepository;

use Modules\Iprofile\Repositories\UserRepository;
use Modules\Iprofile\Repositories\AddressRepository;

// Events
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Events\OrderWasUpdated;

//Support
use Illuminate\Support\Facades\Auth;
use Modules\Icommerce\Support\Order as orderSupport;
use Modules\Icommerce\Support\ShippingMethod as shippingMethodSupport;
use Modules\Icommerce\Support\OrderHistory as orderHistorySupport;
use Modules\Icommerce\Support\OrderItem as orderItemSupport;

class OrderApiController extends BaseApiController
{

  private $order;
  private $orderStatusHistory;
  private $profile;
  private $currency;
  private $cart;
  private $paymentMethod;
  private $shippingMethod;
  private $address;
  private $store;

  public function __construct(
    OrderRepository $order,
    OrderHistoryRepository $orderStatusHistory,
    UserRepository $profile,
    AddressRepository $address,
    CurrencyRepository $currency,
    CartRepository $cart,
    PaymentMethodRepository $paymentMethod,
    ShippingMethodRepository $shippingMethod,
    StoreRepository $store
    )
  {
    $this->order = $order;
    $this->orderStatusHistory = $orderStatusHistory;
    $this->profile = $profile;
    $this->address = $address;
    $this->currency = $currency;
    $this->cart = $cart;
    $this->paymentMethod = $paymentMethod;
    $this->shippingMethod = $shippingMethod;
    $this->store = $store;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $orders = $this->order->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => OrderTransformer::collection($orders)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($orders)] : false;

    } catch (\Exception $e) {
      //Message Error
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }

  /** SHOW
   * @param Request $request
   *  URL GET:
   *  &fields = type string
   *  &include = type string
   */
  public function show($criteria, Request $request)
  {
    try {
      //Request to Repository
      $order = $this->order->getItem($criteria,$this->getParamsRequest($request));

      $response = [
        'data' => $order ? new OrderTransformer($order) : '',
      ];

    } catch (\Exception $e) {
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(Request $request)
  {

    \DB::beginTransaction();

    try{

      $data = $request['attributes'] ?? [];//Get data
      
      // Get Car
      $cart = $this->cart->find($data['cart_id']);
      $infor["cart"] = $cart;

      //Get User
      $user = Auth::user();
      //dd($user);
      $userID = $user->id;

      //$userID = 1; //***** Ojo ID de prueba
      $profile = $this->profile->find($userID);
      $infor["profile"] = $profile;


      //Get Payment Address
      $addressPayment = $this->address->find($data['address_payment_id']);
      $infor["addressPayment"] = $addressPayment;

      //Get Payment Method
      $payment = $this->paymentMethod->find($data['payment_id']);
      $infor["paymentMethod"] = $payment;

      //Get Shipping Address
      $addressShipping = $this->address->find($data['address_shipping_id']);
      $infor["addressShipping"] = $addressShipping;

      //Get Shipping Method Name
      $infor["shippingMethod"] = $data['shipping_name'];

      //Get Currency
      $currency = $this->currency->findByAttributes(array("status" => 1));
      $infor["currency"] = $currency;

      // Fix Data to Send Shipping Methods
      $areaMapId = isset($data['areamap_id']) ? $data['areamap_id'] : "";
      $supportShipping = new shippingMethodSupport();
      $dataMethods = $supportShipping->fixDataSend($cart,$addressShipping,$areaMapId);

      //Get Shipping Methods with calculates
      $shippingMethods = $this->shippingMethod->getCalculations(new Request($dataMethods));

      //Get Shipping Method Price
      $shippingPrice = $supportShipping->searchPriceWithName($shippingMethods,$data['shipping_name']);
      $infor["shippingPrice"] = $shippingPrice;

      //Get Store
      $store = $this->store->find($data['store_id']);
      $infor["store"] = $store;

      // Fix Data Order
      $supportOrder = new orderSupport();
      $data = $supportOrder->fixData($request,$infor);
      
      //Validate Request Order
      $this->validateRequestApi(new OrderRequest($data));

      // Data Order History
      $supportOrderHistory = new orderHistorySupport(1,1);
      $dataOrderHistory = $supportOrderHistory->getData();
      $data["orderHistory"] = $dataOrderHistory;

      // Data Order Items
      $supportOrderItem = new orderItemSupport();
      $dataOrderItem = $supportOrderItem->fixData($cart->products);
      $data["orderItems"] = $dataOrderItem;

      //Create
      $order = $this->order->create($data);

      //Response
      $response = ["data" => new OrderTransformer($order)];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

        \Log::error($e);
        \DB::rollback();//Rollback to Data Base
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
    }

    return response()->json($response, $status ?? 200);

  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update($criteria, Request $request)
  {
    try {

      \DB::beginTransaction();

      $params = $this->getParamsRequest($request);

      $data = $request->all();

      // Data Order History
      $supportOrderHistory = new orderHistorySupport($data["status_id"],1);
      $dataOrderHistory = $supportOrderHistory->getData();
      $data["orderHistory"] = $dataOrderHistory;

      $order = $this->order->updateBy($criteria,$data,$params);

      $response = ['data' => new OrderTransformer($order)];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

      \Log::error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
      

    }

    return response()->json($response, $status ?? 200);

  }


  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function delete($criteria, Request $request)
  {
    try {

      $this->order->deleteBy($criteria,$this->getParamsRequest($request));

      $response = ['data' => ''];

    } catch (\Exception $e) {
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }

}
