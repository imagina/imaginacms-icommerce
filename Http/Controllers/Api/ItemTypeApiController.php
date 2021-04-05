<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\ItemTypeTransformer;


// Repositories
use Modules\Icommerce\Repositories\ItemTypeRepository;


class ItemTypeApiController extends BaseApiController
{
  
  private $itemType;


  public function __construct(ItemTypeRepository $itemType)
  {
    $this->itemType = $itemType;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $itemTypes = $this->itemType->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => ItemTypeTransformer::collection($itemTypes)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($itemTypes)] : false;

    } catch (\Exception $e) {
      //Message Error
      \Log::error($e->getMessage());
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
      $itemType = $this->itemType->getItem($criteria,$this->getParamsRequest($request));

      $response = [
        'data' => $itemType ? new ItemTypeTransformer($itemType) : '',
      ];

    } catch (\Exception $e) {
      \Log::error($e->getMessage());
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
      $this->itemType->create($request->all());

      $response = ['data' => ''];

    } catch (\Exception $e) {
      \Log::error($e->getMessage());
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

      \DB::beginTransaction();

      $params = $this->getParamsRequest($request);

      $data = $request->all();

      $itemType = $this->itemType->updateBy($criteria, $data,$params);

      $response = ['data' => new ItemTypeTransformer($itemType)];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {
      \Log::error($e->getMessage());
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

      $this->itemType->deleteBy($criteria,$this->getParamsRequest($request));

      $response = ['data' => ''];

    } catch (\Exception $e) {
      \Log::error($e->getMessage());
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
}
