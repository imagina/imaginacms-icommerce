<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Repositories\OrderRepository;

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

  //TODO AGREGAR EL UPDATE MEJORADO
}
