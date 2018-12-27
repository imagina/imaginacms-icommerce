<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\CouponRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\CouponTransformer;

// Entities
use Modules\Icommerce\Entities\Coupon;

class CouponApiController extends BaseApiController
{
  private $coupon;
  
  public function __construct()
  {
    $this->coupon = app('Modules\Icommerce\Repositories\CouponRepository');
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $coupons = $this->coupon->index($this->getParamsRequest());
      
      //Response
      $response = ['data' => CouponTransformer::collection($coupons)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($coupons)] : false;
      
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
      $coupon = $this->coupon->show($criteria,$this->getParamsRequest());
      
      $response = [
        'data' => $coupon ? new CouponTransformer($coupon) : '',
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
  public function create(CouponRequest $request)
  {
    try {
     $this->coupon->create($request->all());
      
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
  public function update($criteria, CouponRequest $request)
  {
    try {
      $this->coupon->updateBy($criteria, $request->all(),$this->getParamsRequest());
      
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
      $this->coupon->deleteBy($criteria,$this->getParamsRequest());
      
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
