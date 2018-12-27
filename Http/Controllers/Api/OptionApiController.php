<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\OptionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\OptionTransformer;

// Entities
use Modules\Icommerce\Entities\Option;

class OptionApiController extends BaseApiController
{
  private $option;
  
  public function __construct()
  {
    $this->option = app('Modules\Icommerce\Repositories\OptionRepository');
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $options = $this->option->index($this->getParamsRequest());
      
      //Response
      $response = ['data' => OptionTransformer::collection($options)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($options)] : false;
      
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
      $option = $this->option->show($criteria,$this->getParamsRequest());
      
      $response = [
        'data' => $option ? new OptionTransformer($option) : '',
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
  public function create(OptionRequest $request)
  {
    try {
      $this->option->create($request->all());
      
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
  public function update($criteria, OptionRequest $request)
  {
    try {
      $this->option->updateBy($criteria, $request->all(),$this->getParamsRequest());
      
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
      $this->option->deleteBy($criteria,$this->getParamsRequest());
      
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
