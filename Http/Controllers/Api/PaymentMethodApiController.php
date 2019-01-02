<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\PaymentMethodRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\PaymentMethodTransformer;

// Entities
use Modules\Icommerce\Entities\PaymentMethod;

// Repositories
use Modules\Icommerce\Repositories\PaymentMethodRepository;

class PaymentMethodApiController extends BaseApiController
{
  private $paymentMethod;

  public function __construct(PaymentMethodRepository $paymentMethod)
  {
    $this->paymentMethod = $paymentMethod;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $paymentMethods = $this->paymentMethod->getItemsBy($this->getParamsRequest());

      //Response
      $response = ['data' => PaymentMethodTransformer::collection($paymentMethods)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($paymentMethods)] : false;

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
      $paymentMethod = $this->paymentMethod->getItem($criteria, $this->parametersUrl());

      $response = [
        'data' => $paymentMethod ? new PaymentMethodTransformer($paymentMethod) : '',
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
  public function create(PaymentMethodRequest $request)
  {
    try {
      $this->paymentMethod->create($request->all());

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
  public function update($criteria, PaymentMethodRequest $request)
  {
    try {

      $this->paymentMethod->updateBy($criteria, $request->all(), $this->parametersUrl());

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

      $this->paymentMethod->deleteBy($criteria, $this->parametersUrl());

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
