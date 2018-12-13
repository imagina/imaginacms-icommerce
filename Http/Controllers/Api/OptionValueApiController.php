<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\OptionValueRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\OptionValueTransformer;

class OptionValueApiController extends BaseApiController
{
  private $optionValue;
  
  public function __construct()
  {
    $this->optionValue = app('Modules\Icommerce\Repositories\OptionValueRepository');
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $optionValues = $this->optionValue->index($this->getParamsRequest());
      
      //Response
      $response = ['data' => OptionValueTransformer::collection($optionValues)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($optionValues)] : false;
      
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
  public function show($id, Request $request)
  {
    try {
      //Request to Repository
      $optionValue = $this->optionValue->show($id,$this->getParamsRequest());
      
      $response = [
        'data' => $optionValue ? new OptionValueTransformer($optionValue) : '',
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
  public function create(OptionValueRequest $request)
  {
    try {
      $this->optionValue->create($request->all());
      
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
  public function update($id, OptionValueRequest $request)
  {
    try {
      $optionValue = $this->optionValue->find($id);
      $this->optionValue->update($optionValue, $request->all());
      
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
  public function delete($id, Request $request)
  {
    try {
      $optionValue = $this->optionValue->find($id);
      $this->optionValue->destroy($optionValue);
      
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
