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

// Repositories
use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Icommerce\Repositories\OptionValueRepository;

class OptionApiController extends BaseApiController
{
  private $option;
  private $optionValue;

  public function __construct(OptionRepository $option, OptionValueRepository $optionValue)
  {
    $this->option = $option;
    $this->optionValue = $optionValue;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Get params
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $options = $this->option->getItemsBy($params);

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

  /**
   * GET A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function show($criteria, Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
        $dataEntity = $this->option->getItem($criteria, $params);

      //Break if no found item
      if (!$dataEntity) throw new \Exception('Item not found', 404);

      //Response
      $response = ["data" => new OptionTransformer($dataEntity)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * CREATE A ITEM
   *
   * @param Request $request
   * @return mixed
   */
  public function create(Request $request)
  {
    \DB::beginTransaction();
    try {
      $data = $request->input('attributes') ?? [];//Get data
      //Validate Request
      $this->validateRequestApi(new OptionRequest((array)$data));

      //Create item
      $option = $this->option->create($data);

      //Response
      $response = ["data" => ''];
      \DB::commit(); //Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * UPDATE ITEM
   *
   * @param $criteria
   * @param Request $request
   * @return mixed
   */
  public function update($criteria, Request $request)
  {
    \DB::beginTransaction(); //DB Transaction
    try {
      //Get data
      $data = $request->input('attributes') ?? [];//Get data

      //Validate Request
      $this->validateRequestApi(new OptionRequest((array)$data));

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

        //Request to Repository
        $dataEntity = $this->option->getItem($criteria, $params);

        //Break if no found item
        if (!$dataEntity) throw new \Exception('Item not found', 404);

      //Request to Repository
      $this->option->update($dataEntity, $data);

      //Response
      $response = ["data" => 'Item Updated'];
      \DB::commit();//Commit to DataBase
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

  /**
   * DELETE A ITEM
   *
   * @param $criteria
   * @return mixed
   */
  public function delete($criteria, Request $request)
  {
    \DB::beginTransaction();
    try {
      //Get params
      $params = $this->getParamsRequest($request);

        //Request to Repository
        $dataEntity = $this->option->getItem($criteria, $params);

        //Break if no found item
        if (!$dataEntity) throw new \Exception('Item not found', 404);

      //call Method delete
      $this->option->destroy($dataEntity);

      //Response
      $response = ["data" => "Item deleted"];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }

    //Return response
    return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
  }

}
