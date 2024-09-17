<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Icrud\Controllers\BaseCrudController;

//Model
use Modules\Icommerce\Entities\Coupon;
use Modules\Icommerce\Repositories\CouponRepository;

class CouponApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;
  
  public function __construct(Coupon $model, CouponRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
  
  /**
   * Validate Coupon.
   * @return Response
   */
  public function validateCoupon(Request $request)
  {
    try {
      
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $coupon = $this->coupon->validateCoupon($params);
      
      //Break if no found item
      if (!$coupon) throw new \Exception('Item not found', 404);
      
      //Response
      $response = ["data" => new CouponTransformer($coupon)];
      
    } catch (\Exception $exception) {
      \Log::error($exception->getMessage());
      $status = 500;
      $response = [
        'errors' => $exception->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
}
