<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\CartRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\CartTransformer;

// Repositories
use Modules\Icommerce\Repositories\CartRepository;

class CartApiController extends BaseApiController
{
  private $cart;
  
  public function __construct(
    CartRepository $cart)
  {
    $this->cart = $cart;
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
      $carts = $this->cart->index($p->page, $p->take, $p->filter, $p->include, $p->fields);
      
      //Response
      $response = ['data' => CartTransformer::collection($carts)];
      //If request pagination add meta-page
      $p->page ? $response['meta'] = ['page' => $this->pageTransformer($carts)] : false;
      
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
  public function show($id, Request $request)
  {
    try {
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, [], []);
      
      //Request to Repository
      $cart = $this->cart->show($p->filter, $p->include, $p->fields, $id);
      
      $response = [
        'data' => $cart ? new CartTransformer($cart) : '',
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
  public function create(CartRequest $request)
  {
    try {
      $cart = $this->cart->create($request->all());
  
      // sync tables
      if ($cart)
        if (isset($request->products))
          $cart->products()->sync($request->products);
      
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
  public function update($id, CartRequest $request)
  {
    try {
      $cart = $this->cart->find($id);
      $cart = $this->cart->update($cart, $request->all());
  
      // sync tables
      if ($cart)
        if (isset($request->products))
          $cart->products()->sync($request->products);
      
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
      $cart = $this->cart->find($id);
      $cart->delete();
      
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
