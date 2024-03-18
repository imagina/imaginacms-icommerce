<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ShippingMethod;
use Modules\Icommerce\Repositories\ShippingMethodRepository;

class ShippingMethodApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ShippingMethod $model, ShippingMethodRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }


  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function calculations(Request $request)
  {
    try {

      $data = $request->input('attributes');

      //Request to Repository
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      $shippingMethods = $this->shippingMethod->getCalculations($data, $params);

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
}
