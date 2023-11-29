<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Option;
use Modules\Icommerce\Repositories\OptionRepository;

class OptionApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Option $model, OptionRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
  }
  
  /** TODO REVISAR
   * UPDATE ORDER
   *
   * @param Request $request
   * @return mixed
   */
  public function updateOrderOptions (Request $request)
  {
    \DB::beginTransaction();
    try {
      $data = $request->input('attributes') ?? [];
      
      $options = $this->optionOrdener->handle($data['options']);
      $response = [
        "data" => 'order Updated'
      ];
      $status = 200;
      \DB::commit();
    } catch (\Exception $e) {
      \DB::rollback();
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    return response()->json($response, 200);
  }
}
