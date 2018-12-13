<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\TaxRateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\TaxRateTransformer;


class TaxRateApiController extends BaseApiController
{
  private $taxRate;
  
  public function __construct()
  {
    $this->taxRate = app('Modules\Icommerce\Repositories\TaxRateRepository');
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $taxRates = $this->taxRate->index($this->getParamsRequest());
      
      //Response
      $response = ['data' => TaxRateTransformer::collection($taxRates)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($taxRates)] : false;
      
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
      $taxRate = $this->taxRate->show($id,$this->getParamsRequest());
      
      $response = [
        'data' => $taxRate ? new TaxRateTransformer($taxRate) : '',
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
  public function create(TaxRateRequest $request)
  {
    try {
      $taxRate = $this->taxRate->create($request->all());
      
      // sync table
      if ($taxRate)
        if (isset($request->rates))
          $taxRate->rates()->sync($request->rates);
      
      
      
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
  public function update($id, TaxRateRequest $request)
  {
    try {
      
      $taxRate = $this->taxRate->find($id);
      $taxRate = $this->taxRate->update($taxRate, $request->all());
      
      // sync tables
      if ($taxRate)
        if (isset($request->rates))
          $taxRate->rates()->sync($request->rates);
        else
          $taxRate->rates()->detach();
      
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
      $taxRate = $this->taxRate->find($id);
      $this->taxRate->destroy($taxRate);
      
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
