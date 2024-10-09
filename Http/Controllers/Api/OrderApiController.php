<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Repositories\OrderRepository;

//Required to Method Update
use Modules\Icommerce\Support\OrderHistory as orderHistorySupport;
use Modules\Icommerce\Events\OrderWasUpdated;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;
use Modules\Icommerce\Events\OrderWasProcessed;
use Modules\Icommerce\Entities\OrderStatusHistory;
use Modules\Core\Icrud\Transformers\CrudResource;

class OrderApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Order $model, OrderRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
  
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      $user = \Auth::guard('api')->user() ?? \Auth::user();
    
      if (!isset($params->filter->key) && !isset($user)) {
        throw new \Exception('Unauthorized action.', 401);
      }
 
      //Response
      $response = parent::show($criteria, $request);
      
    } catch (\Exception $e) {
      \Log::error($e->getMessage());
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    return $response;
  }
  
    /**
     * creating a new resource.
     * @return Response
     */
    public function create(Request $request)
  {
  
    \Log::info('Icommerce: OrderApiController|Create');
  
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
  
    \Log::info('Icommerce: OrderApiController|Create|END');
  
    return response()->json($response, $status ?? 200);
  }
  
  /**
   * 
   */
  public function update($criteria, Request $request)
  {

    //\Log::info('Icommerce: OrderApiController|Update');
    try {

      \DB::beginTransaction();

      $params = $this->getParamsRequest($request);

      $data = $request->input('attributes');


      // Data Order History
      $supportOrderHistory = new orderHistorySupport($data["status_id"], 1);
      $dataOrderHistory = $supportOrderHistory->getData();
      $data["orderHistory"] = $dataOrderHistory;

      $data = \Arr::only($data, ['status_id', 'options', 'orderHistory', 'suscription_id', 'suscription_token', 'comment']);

      //Request to Repository
      $dataEntity = $this->modelRepository->getItem($criteria, $params);

      //Break if no found item
      if (!$dataEntity) throw new \Exception('Item not found', 404);

      $order = $this->modelRepository->update($dataEntity, $data);

      $response = ['data' => CrudResource::transformData($order)];

      \DB::commit(); //Commit to Data Base
      // Event to send Email
      event(new OrderWasUpdated($order));

      if (isset($data["orderHistory"])) {
        
        \Log::info('Icommerce: OrderApiController|Update|CreateOrderHistory');

        $orderStatusHistory = OrderStatusHistory::create([
          "order_id" => $order->id,
          "notify" => 1,
          "status" => $data["status_id"],
          "comment" => $data["comment"] ?? null
        ]);

        event(new OrderStatusHistoryWasCreated($orderStatusHistory));

        if ($data["status_id"] == 13) // Processed
          event(new OrderWasProcessed($order));
      }
    } catch (\Exception $e) {
      \Log::error($e->getMessage());

      \DB::rollback(); //Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $this->getErrorMessage($e)];
    }

    \Log::info('Icommerce: OrderApiController|Update|END');

    return response()->json($response, $status ?? 200);
  }

}
