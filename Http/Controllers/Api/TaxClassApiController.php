<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\TaxClassRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\TaxClassTransformer;

// Entities
use Modules\Icommerce\Entities\TaxClass;

// Repositories
use Modules\Icommerce\Repositories\TaxClassRepository;

class TaxClassApiController extends BaseApiController
{
  private $taxClass;

  public function __construct(TaxClassRepository $taxClass)
  {
    $this->taxClass = $taxClass;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $taxClasses = $this->taxClass->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => TaxClassTransformer::collection($taxClasses)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($taxClasses)] : false;

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
      $taxClass = $this->taxClass->getItem($criteria,$this->getParamsRequest($request));

      $response = [
        'data' => $taxClass ? new TaxClassTransformer($taxClass) : '',
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
    try {

      $data = $request->input('attributes') ?? [];//Get data

      $taxClass = $this->taxClass->create($data);

      $response = ['data' => $taxClass];

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
  public function update($criteria, Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      //Get data
      $data = $request->input('attributes') ?? [];//Get data

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      $dataEntity = $this->taxClass->getItem($criteria, $params);

      if (!$dataEntity) throw new Exception('Item not found', 204);

      //Request to Repository
      $this->taxClass->update($dataEntity, $data);
      //Response
      $response = ["data" => 'Item Updated'];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \Log::error($e);
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function delete($criteria, Request $request)
  {
    try {

      $this->taxClass->deleteBy($criteria, $this->getParamsRequest($request));

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
