<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;
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

use Modules\Iprofile\Repositories\UserApiRepository;
use Modules\Iprofile\Repositories\AddressRepository;
use Illuminate\Support\Arr;

// Events
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Events\OrderWasUpdated;

//Support
use Illuminate\Support\Facades\Auth;
use Modules\Icommerce\Support\Order as orderSupport;
use Modules\Icommerce\Support\ShippingMethod as shippingMethodSupport;
use Modules\Icommerce\Support\OrderHistory as orderHistorySupport;
use Modules\Icommerce\Support\OrderItem as orderItemSupport;
use Modules\Icommerce\Support\validateCoupons;

class OrderApiController extends BaseApiController
{

    private $order;
    private $orderStatusHistory;
    private $user;
    private $currency;
    private $cart;
    private $paymentMethod;
    private $shippingMethod;
    private $address;
    private $store;

    public function __construct(
        OrderRepository $order,
        OrderHistoryRepository $orderStatusHistory,
        UserApiRepository $user,
        AddressRepository $address,
        CurrencyRepository $currency,
        CartRepository $cart,
        PaymentMethodRepository $paymentMethod,
        ShippingMethodRepository $shippingMethod
    )
    {
        $this->order = $order;
        $this->orderStatusHistory = $orderStatusHistory;
        $this->user = $user;
        $this->address = $address;
        $this->currency = $currency;
        $this->cart = $cart;
        $this->paymentMethod = $paymentMethod;
        $this->shippingMethod = $shippingMethod;
        if(is_module_enabled('Marketplace')){
            $this->store =app('Modules\Marketplace\Repositories\StoreRepository');
        }else{
            $this->store =app('Modules\Icommerce\Repositories\StoreRepository');
        }
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $dataEntity = $this->order->getItemsBy($params);

            //Response
            $response = [
                "data" => OrderTransformer::collection($dataEntity)
            ];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


    /**
     * GET A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            $user = \Auth::guard('api')->user() ?? \Auth::user();

            if (!isset($params->filter->key) && !isset($user)) {
                throw new \Exception('Unauthorized action.', 401);
            }
            //Request to Repository
            $dataEntity = $this->order->getItem($criteria, $params);

            //Break if no found item
            if (!$dataEntity) throw new \Exception('Item not found', 404);

            //Response
            $response = ["data" => new OrderTransformer($dataEntity)];

        } catch (\Exception $e) {
            \Log::error($e);
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {

        \DB::beginTransaction();

        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $data = $request['attributes'] ?? [];//Get data
            $couponCode=$data['coupon_code'];
            //Break if the data is empty
            if (!count($data)) throw new \Exception('The some errors in the data sent', 400);

            // Get Cart
            $cart = $this->cart->find($data['cart_id']);

            //Break if cart no found
            if (!$cart) throw new \Exception('The cart selected doesn\'t exist', 400);

            $data["cart"] = $cart;

            //Get Added by id
            $user = $params->user;
            $data["addedBy"] = $user;

            //Get Customer Id
            if (isset($data["customer_id"])) {
                $customer = $this->user->find($data["customer_id"]);
                $data["customer"] = $customer;
            }

            //Get Payment Method
            $payment = $this->paymentMethod->find($data['payment_method_id']);
            $data["paymentMethod"] = $payment;

            //Get Shipping Method Name
            $data["shippingMethod"] = $this->shippingMethod->find($data['shipping_method_id']);

            //Get Store
            $data["store"] = $this->store->find($data['store_id']);


            //Get Currency
            if (!isset($data["currency_id"])) {
                $currency = $this->currency->findByAttributes(["default_currency" => 1]);
                if (!$currency) {
                    $data["currency_id"] = null;
                } else {
                    $data["currency_id"] = $currency;
                }
            }
            $data["currency"] = $currency;


            $supportShipping = new shippingMethodSupport();

            $dataMethods = $supportShipping->fixDataSend((object)$data);

            //Get Shipping Methods with calculates
            $shippingMethods = $this->shippingMethod->getCalculations(new Request($dataMethods));

            //Get Shipping Method Price
            $shippingPrice = $supportShipping->searchPriceByName($shippingMethods, $data['shipping_method']);
            $data["shippingPrice"] = $shippingPrice;

            // Coupons
            $validateCoupons = new validateCoupons();
            $discount = $validateCoupons->validateCode($data['coupon_code'], $data['cart_id'],$data['store_id']);
            $data["discount"] = $discount->discount;


            // Fix Data Order
            $supportOrder = new orderSupport();
            $data = $supportOrder->fixData($data, $request);


            //Validate Request Order
            $this->validateRequestApi(new OrderRequest($data));

            //Get data Extra Options
            $data['options'] = $data['options'] ?? [];

            // Data Order History
            $supportOrderHistory = new orderHistorySupport(1, 1);
            $dataOrderHistory = $supportOrderHistory->getData();
            $data["orderHistory"] = $dataOrderHistory;

            // Data Order Items
            $supportOrderItem = new orderItemSupport();
            $dataOrderItem = $supportOrderItem->fixData($cart->products);
            $data["orderItems"] = $dataOrderItem;

            //Create
            $order = $this->order->create($data);

            if ($discount->status == 1) {
                $coupon = $validateCoupons->getCouponByCode($couponCode);
                $validateCoupons->redeemCoupon($coupon->id, $order->id, $customer->id, $order->total);
            }

            $data["orderID"] = $order->id;

            $paymentData = $this->validateResponseApi(
                app($payment->options->init)->init(new Request($data))
            );
            $updateCart=$this->cart->update($cart,['status'=>2]);
            //Response
            $response = ["data" => [
                "orderId" => $order->id,
                "paymentData" => $paymentData
            ]
            ];

            \DB::commit(); //Commit to Data Base

            // Event To create OrderItems, OrderOptions, next send email
            event(new OrderWasCreated($order, $data['orderItems']));
            event(new OrderStatusHistoryWasCreated($order));

        } catch (\Exception $e) {

            \Log::error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage(), 'line' => $e->getLine(), 'trace' => $e->getTrace()];
        }

        return response()->json($response, $status ?? 200);

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update($criteria, Request $request)
    {
        try {

            \DB::beginTransaction();

            $params = $this->getParamsRequest($request);

            $data = $request->input('attributes');

            // Data Order History
            $supportOrderHistory = new orderHistorySupport($data["status_id"], 1);
            $dataOrderHistory = $supportOrderHistory->getData();
            $data["orderHistory"] = $dataOrderHistory;

            $data = Arr::only($data, ['status_id', 'options', 'orderHistory']);

            //Request to Repository
            $dataEntity = $this->order->getItem($criteria, $params);

            //Break if no found item
            if (!$dataEntity) throw new \Exception('Item not found', 404);


            $order = $this->order->update($dataEntity, $data);

            $response = ['data' => new OrderTransformer($order)];

            \DB::commit(); //Commit to Data Base
            // Event to send Email
            event(new OrderWasUpdated($order));

            if (isset($data["orderHistory"])) {
                event(new OrderStatusHistoryWasCreated($order));
            }

        } catch (\Exception $e) {

            \Log::error($e);
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];


        }

        return response()->json($response, $status ?? 200);

    }


    /**
     * DELETE A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $dataEntity = $this->order->getItem($criteria, $params);

            //Break if no found item
            if (!$dataEntity) throw new \Exception('Item not found', 404);

            //call Method delete
            $this->order->destroy($dataEntity);

            //Response
            $response = ["data" => ""];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


}
