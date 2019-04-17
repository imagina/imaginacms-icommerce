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

// Repositories
use Modules\Icommerce\Repositories\WishlistRepository;

class WishlistApiController extends BaseApiController
{
  private $wishlist;

  public function __construct(WishlistRepository $wishlist)
  {
    $this->wishlist = $wishlist;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $wishlists = $this->wishlist->getItemsBy($this->getParamsRequest($request));

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

      $params = $this->getParamsRequest($request);

      //Request to Repository
      $wishlist = $this->wishlist->getItem($criteria,$params);

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
  public function create(Request $request)
  {

    \DB::beginTransaction();

    try {

      //Get data
      $data = $request['attributes'] ?? [];

      //Validate Request Order
      $this->validateRequestApi(new WishlistRequest($data));

      // Create
      $wishlist = $this->wishlist->create($data);

      $response = ['data' => new WishlistTransformer($wishlist)];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

      \Log::error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];

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

      \DB::beginTransaction();

      $params = $this->getParamsRequest($request);

      $data = $request->all();

      //Validate Request Order
      $this->validateRequestApi(new WishlistRequest($data));

      $wishlist = $this->wishlist->updateBy($criteria, $data ,$params);

      $response = ['data' => new WishlistTransformer($wishlist)];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

      \Log::error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
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

      \DB::beginTransaction();

      $params = $this->getParamsRequest($request);

      $this->wishlist->deleteBy($criteria,$params);

      $response = ['data' => ''];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

      \Log::error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    return response()->json($response, $status ?? 200);
  }
}
