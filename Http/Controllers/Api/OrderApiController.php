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

// Repositories
use Modules\Icommerce\Repositories\OrderRepository;


class OrderApiController extends BaseApiController
{
  
  private $order;
  
  
  public function __construct(
    OrderRepository $order)
  {
    $this->order = $order;
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {
    try {
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, ['status' => [1]], []);
      
      //Request to Repository
      $orders = $this->order->index($p->page, $p->take, $p->filter, $p->include, $p->fields);
      
      //Response
      $response = ['data' => OrderTransformer::collection($orders)];
      //If request pagination add meta-page
      $p->page ? $response['meta'] = ['page' => $this->pageTransformer($orders)] : false;
      
    } catch (\Exception $e) {
      //Message Error
      $status = 400;
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
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, [], []);
      
      //Request to Repository
      $order = $this->order->show($p->filter, $p->include, $p->fields, $criteria);
      
      $response = [
        'data' => $order ? new OrderTransformer($order) : '',
      ];
      
    } catch (\Exception $e) {
      $status = 400;
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
        // order Options
        if (isset($request->options))
          $order->options()->sync($request->options);
        
        // order Option Values
        if (isset($request->optionValues))
          $order->optionValues()->sync($request->optionValues);
        
        // Related Products
        if (isset($request->relatedProducts))
          $order->relatedProducts()->sync($request->relatedProducts);
        
        // Discounts
        if (isset($request->discounts))
          $order->discounts()->sync($request->discounts);
        
      }
      
      $response = ['data' => ''];
      
    } catch (\Exception $e) {
      $status = 400;
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
        // order Options
        if (isset($request->options))
          $order->options()->sync($request->options);
        
        // order Option Values
        if (isset($request->optionValues))
          $order->optionValues()->sync($request->optionValues);
        
        // Related Products
        if (isset($request->relatedProducts))
          $order->relatedProducts()->sync($request->relatedProducts);
        
        // Discounts
        if (isset($request->discounts))
          $order->discounts()->sync($request->discounts);
        
      }
      
      $response = ['data' => ''];
      
    } catch (\Exception $e) {
      $status = 400;
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
      $status = 400;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
}
