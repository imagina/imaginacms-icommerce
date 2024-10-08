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
  public function updateOrderOptions(Request $request)
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

  /**
   * Controller to delete model by criteria
   *
   * @return mixed
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);

      //Validation to delete
      app('Modules\Icommerce\Services\OptionService')->checkOptionHasGroup($criteria);

      //Delete methomodel
      $this->modelRepository->deleteBy($criteria, $params);

      //Response
      $response = ['data' => 'Item deleted'];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback(); //Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ['messages' => [['message' => $e->getMessage(), 'type' => 'error']]];
    }

    //Return response
    return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
  }

}
