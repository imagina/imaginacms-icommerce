<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\OrderHistoryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\OrderHistoryTransformer;

// Entities
use Modules\Icommerce\Entities\OrderStatusHistory;

// Repositories
use Modules\Icommerce\Repositories\OrderHistoryRepository;

class OrderStatusHistoryApiController extends BaseApiController
{
  private $orderHistory;

  public function __construct(OrderHistoryRepository $orderHistory)
  {
    $this->orderHistory = $orderHistory;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.

      //Request to Repository
      $orderHistories = $this->orderHistory->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => OrderHistoryTransformer::collection($orderHistories)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($orderHistories)] : false;

    } catch (\Exception $e) {
        \Log::error($e);
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
      $orderHistory = $this->orderHistory->getItem($criteria, $this->getParamsRequest($request));

      $response = [
        'data' => $orderHistory ? new OrderHistoryTransformer($orderHistory) : '',
      ];

    } catch (\Exception $e) {
        \Log::error($e);
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
    try {
      $data = $request->input('attributes');

      $orderHistory = $this->orderHistory->create($data);

      $response = ['data' => $orderHistory];

    } catch (\Exception $e) {
        \Log::error($e);
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
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

      $this->orderHistory->updateBy($criteria, $request->all(), $this->getParamsRequest($request));

      $response = ['data' => ''];

    } catch (\Exception $e) {
        \Log::error($e);
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
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

      $this->orderHistory->deleteBy($criteria, $this->getParamsRequest($request));

      $response = ['data' => ''];

    } catch (\Exception $e) {
        \Log::error($e);
        $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
}
