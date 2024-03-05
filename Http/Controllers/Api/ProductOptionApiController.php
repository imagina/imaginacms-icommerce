<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\ProductOption;
use Modules\Icommerce\Repositories\ProductOptionRepository;

class ProductOptionApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(ProductOption $model, ProductOptionRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
  
  //TODO REVISAR SI ESTO SI SE USA ACTUALMENTE
  public function updateOrder (Request $request)
  {
    try {
      $data = $request->input('attributes');
      $response = [
        'data' => $this->productOptionOrdener->handle($data['options'])
      ];
      $status = 200;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status);
    
  }
  
}
