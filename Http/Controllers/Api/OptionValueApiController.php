<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\OptionValue;
use Modules\Icommerce\Repositories\OptionValueRepository;
// Support
use Modules\Icommerce\Support\OptionValuesOrdener;

class OptionValueApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;
  private $optionValuesOrdener;

  public function __construct(OptionValue $model, OptionValueRepository $modelRepository, OptionValuesOrdener $optionValuesOrdener)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
    $this->optionValuesOrdener = $optionValuesOrdener;
  }

  //TODO REVISAR
  public function updateOrder (Request $request)
  {
    try {
      $data = $request->input('attributes');
      $response = [
        'data' => $this->optionValuesOrdener->handle($data['values'])
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
      app('Modules\Icommerce\Services\OptionService')->checkOptionHasGroup($criteria,"optionValue");

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
