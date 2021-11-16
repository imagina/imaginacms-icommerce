<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Entities\OrderStatusHistory;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;
use Modules\Icommerce\Events\OrderWasProcessed;
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
    private $orderService;
    private $orderStatusHistory;
    private $user;
    private $currency;
    private $cart;
    private $paymentMethod;
    private $shippingMethod;
    private $address;
    private $store;
    private $setting;

    public function __construct(
        OrderRepository $order
    )
    {
        $this->order = $order;
        $this->store =app('Modules\Icommerce\Repositories\StoreRepository');

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
          \Log::error($e->getMessage());
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
          \Log::error($e->getMessage());
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

      $this->orderService = app('Modules\Icommerce\Services\OrderService');
      
      \DB::beginTransaction();

      try {
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        $data = $request->input('attributes');

        $orderServiceResponse = $this->orderService->create($data);

        //Response
        $response = ["data" => $orderServiceResponse
        ];

        \DB::commit(); //Commit to Data Base

      } catch (\Exception $e) {
        \Log::error($e->getMessage());
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

            $data = Arr::only($data, ['status_id', 'options', 'orderHistory','suscription_id','suscription_token']);

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
              $orderStatusHistory = OrderStatusHistory::create([
                "order_id" => $order->id,
                "notify" => 1,
                "status" => $data["status_id"]
              ]);

                event(new OrderStatusHistoryWasCreated($orderStatusHistory));
                
                if($data["status_id"] == 13) // Processed
                  event(new OrderWasProcessed($order));
            }



        } catch (\Exception $e) {
          \Log::error($e->getMessage());

            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $this->getErrorMessage($e)];


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
          \Log::error($e->getMessage());
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


}
