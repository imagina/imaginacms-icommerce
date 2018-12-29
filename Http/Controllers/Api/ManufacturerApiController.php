<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\ManufacturerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\ManufacturerTransformer;

// Entities
use Modules\Icommerce\Entities\Manufacturer;

// Repositories
use Modules\Icommerce\Repositories\ManufacturerRepository;

class ManufacturerApiController extends BaseApiController
{
  private $manufacturer;

  public function __construct(ManufacturerRepository $manufacturer)
  {
    $this->manufacturer = $manufacturer;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $manufacturers = $this->manufacturer->index($this->getParamsRequest());

      //Response
      $response = ['data' => ManufacturerTransformer::collection($manufacturers)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($manufacturers)] : false;

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
      $manufacturer = $this->manufacturer->show($criteria,$this->getParamsRequest());

      $response = [
        'data' => $manufacturer ? new ManufacturerTransformer($manufacturer) : '',
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
  public function create(ManufacturerRequest $request)
  {
    try {
      $this->manufacturer->create($request->all());

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
  public function update($criteria, ManufacturerRequest $request)
  {
    try {
      $this->manufacturer->updateBy($criteria, $request->all(),$this->getParamsRequest());

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
      $this->manufacturer->deleteBy($criteria,$this->getParamsRequest());

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
