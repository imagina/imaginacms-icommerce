<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\WishlistRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\WishlistTransformer;

// Entities
use Modules\Icommerce\Entities\Wishlist;

class WishlistApiController extends BaseApiController
{
  private $wishlist;
  
  public function __construct()
  {
    $this->wishlist = app('Modules\Icommerce\Repositories\WishlistRepository');
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $wishlists = $this->wishlist->index($this->getParamsRequest());
      
      //Response
      $response = ['data' => WishlistTransformer::collection($wishlists)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($wishlists)] : false;
      
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
      $wishlist = $this->wishlist->show($criteria,$this->getParamsRequest());
      
      $response = [
        'data' => $wishlist ? new WishlistTransformer($wishlist) : '',
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
  public function create(WishlistRequest $request)
  {
    try {
      $this->wishlist->create($request->all());
      
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
  public function update($criteria, WishlistRequest $request)
  {
    try {
      $this->wishlist->updateBy($criteria, $request->all(),$this->getParamsRequest());
      
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
  public function delete($criteria, Request $request)
  {
    try {
      $this->wishlist->deleteBy($criteria,$this->getParamsRequest());
      
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
