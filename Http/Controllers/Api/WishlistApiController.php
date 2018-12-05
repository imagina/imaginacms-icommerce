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

// Repositories
use Modules\Icommerce\Repositories\WishlistRepository;

class WishlistApiController extends BaseApiController
{
  private $wishlist;
  
  public function __construct(
    WishlistRepository $wishlist)
  {
    $this->wishlist = $wishlist;
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {
    try {
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, ["status" => [1]], []);
      
      //Request to Repository
      $wishlists = $this->wishlist->index($p->page, $p->take, $p->filter, $p->include, $p->fields);
      
      //Response
      $response = ["data" => WishlistTransformer::collection($wishlists)];
      //If request pagination add meta-page
      $p->page ? $response["meta"] = ["page" => $this->pageTransformer($wishlists)] : false;
      
    } catch (\Exception $e) {
      //Message Error
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
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
      $wishlist = $this->wishlist->show($p->filter, $p->include, $p->fields, $id);
      
      $response = [
        "data" => $wishlist ? new WishlistTransformer($wishlist) : "",
      ];
      
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
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
      
      $response = ["data" => ""];
      
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
  
  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update($id, WishlistRequest $request)
  {
    try {
      $wishlist = $this->wishlist->find($id);
      $this->wishlist->update($wishlist, $request->all());
      
      $response = ["data" => ""];
      
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
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
      $wishlist = $this->wishlist->find($id);
      $wishlist->delete();
      
      $response = ["data" => ""];
      
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
}
