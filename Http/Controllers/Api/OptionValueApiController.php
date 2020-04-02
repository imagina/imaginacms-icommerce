<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\OptionValueRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\OptionValueTransformer;

// Entities
use Modules\Icommerce\Entities\OptionValue;

// Repositories
use Modules\Icommerce\Repositories\OptionValueRepository;

// Support
use Modules\Icommerce\Support\OptionValuesOrdener;

class OptionValueApiController extends BaseApiController
{
    private $optionValue;
    private $optionValuesOrdener;


    public function __construct(OptionValueRepository $optionValue, OptionValuesOrdener $optionValuesOrdener)
    {
        $this->optionValue = $optionValue;
        $this->optionValuesOrdener = $optionValuesOrdener;
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
      try {
        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $optionValues = $this->optionValue->getItemsBy($params);

        //Response
        $response = ["data" => OptionValueTransformer::collection($optionValues)];

        //If request pagination add meta-page
        $params->page ? $response["meta"] = ["page" => $this->pageTransformer($optionValues)] : false;
      } catch (\Exception $e) {
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }

      //Return response
      return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
        $dataEntity = $this->optionValue->getItem($criteria, $params);

        //Break if no found item
        if (!$dataEntity) throw new \Exception('Item not found', 404);

        //Response
        $response = ["data" => new OptionValueTransformer($dataEntity)];

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
        $this->validateRequestApi(new OptionValueRequest((array)$data));

        //Create item
        $this->optionValue->create($data);

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
        $this->validateRequestApi(new OptionValueRequest((array)$data));

        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        //Request to Repository
        $dataEntity = $this->optionValue->getItem($criteria, $params);

        //Break if no found item
        if (!$dataEntity) throw new \Exception('Item not found', 404);

        //Request to Repository
        $this->optionValue->update($dataEntity, $data);

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
        $dataEntity = $this->optionValue->getItem($criteria, $params);

        //Break if no found item
        if (!$dataEntity) throw new \Exception('Item not found', 404);

        //call Method delete
        $this->optionValue->destroy($dataEntity);

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

}
