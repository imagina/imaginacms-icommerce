<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\ProductOptionValueRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\ProductOptionValueTransformer;

// Entities
use Modules\Icommerce\Entities\Tag;
use Modules\Icommerce\Entities\Product;

class ProductOptionValueApiController extends BaseApiController
{
  
  private $productOptionValue;
  
  
  public function __construct()
  {
    $this->productOptionValue = app('Modules\Icommerce\Repositories\ProductOptionValueRepository');
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $productOptionValues = $this->productOptionValue->index($this->getParamsRequest());
      
      //Response
      $response = ['data' => ProductOptionValueTransformer::collection($productOptionValues)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($productOptionValues)] : false;
      
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
      $productOptionValue = $this->productOptionValue->show($criteria,$this->getParamsRequest());
      
      $response = [
        'data' => $productOptionValue ? new ProductOptionValueTransformer($productOptionValue) : '',
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
  public function create(ProductOptionValueRequest $request)
  {
    try {
      $this->productOptionValue->create($request->all());
      
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
  public function update($criteria, ProductOptionValueRequest $request)
  {
    try {
      
      $this->productOptionValue->updateBy($criteria, $request->all(), $this->parametersUrl());
      
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
      
      $this->productOptionValue->deleteBy($criteria, $this->parametersUrl());
      
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
