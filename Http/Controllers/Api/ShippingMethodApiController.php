<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\ShippingMethodRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\ShippingMethodTransformer;

// Entities
use Modules\Icommerce\Entities\ShippingMethod;

// Repositories
use Modules\Icommerce\Repositories\ShippingMethodRepository;

class ShippingMethodApiController extends BaseApiController
{
  private $shippingMethod;

  public function __construct(ShippingMethodRepository $shippingMethod)
  {
    $this->shippingMethod = $shippingMethod;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      
      $shippingMethods = $this->shippingMethod->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => ShippingMethodTransformer::collection($shippingMethods)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($shippingMethods)] : false;

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
      $shippingMethod = $this->shippingMethod->getItem($criteria, $this->getParamsRequest($request));

      $response = [
        'data' => $shippingMethod ? new ShippingMethodTransformer($shippingMethod) : '',
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
      $this->shippingMethod->create($request->all());

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
  public function update($criteria, Request $request)
  {
    try {

      $this->shippingMethod->updateBy($criteria, $request->all(), $this->getParamsRequest($request));

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

      $this->shippingMethod->deleteBy($criteria, $this->getParamsRequest($request));

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
