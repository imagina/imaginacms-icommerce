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

class OrderApiController extends BaseApiController
{
  
  private $order;
  private $orderStatusHistory;
  
  
  public function __construct()
  {
    $this->order =  app('Modules\Icommerce\Repositories\OrderRepository');
    $this->orderStatusHistory = app('Modules\Icommerce\Repositories\OrderHistoryRepository');
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $orders = $this->order->index($this->getParamsRequest());
      
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
      $order = $this->order->show($criteria,$this->getParamsRequest());
      
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
  public function create(OrderRequest $request)
  {
    try {
      $order = $this->order->create($request->all());
      
      // sync tables
      if ($order){
        // Order Options
        if (isset($request->coupons))
          $order->coupons()->sync($request->coupons);
        
        // Order Option Values
        if (isset($request->optionValues))
          $order->optionValues()->sync($request->optionValues);
        
        // Products
        if (isset($request->products))
          $order->products()->sync($request->products);
        
        // Status History
        $this->orderStatusHistory->crete([
          'order_id' => $order->id,
          'status' => 0,
          'notify' => 0,
          'comment' => 'first status'
        ]);
        
      }
      
      $response = ['data' => ''];
      
    } catch (\Exception $e) {
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
  public function update($id, OrderRequest $request)
  {
    try {
      
      $order = $this->order->find($id);
      $order = $this->order->update($order, $request->all());
  
      // sync tables
      if ($order){
        // Order Options
        if (isset($request->coupons))
          $order->coupons()->sync($request->coupons);
    
        // Order Option Values
        if (isset($request->optionValues))
          $order->optionValues()->sync($request->optionValues);
    
        // Products
        if (isset($request->products))
          $order->products()->sync($request->products);
    
        // Status History
        $this->orderStatusHistory->crete([
          'order_id' => $order->id,
          'status' => 0,
          'notify' => 0,
          'comment' => 'first status'
        ]);
    
      }
      
      $response = ['data' => ''];
      
    } catch (\Exception $e) {
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
  public function delete($id, Request $request)
  {
    try {
      $order = $this->order->find($id);
      $order->delete();
      
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
