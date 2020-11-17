<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Entities
use Modules\Icommerce\Entities\Store;

// Repositories
use Modules\Icommerce\Repositories\StoreRepository;

// Requests & Response
use Modules\Icommerce\Http\Requests\StoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Transformers
use Modules\Icommerce\Transformers\StoreTransformer;


class StoreApiController extends BaseApiController
{
    private $store;

    public function __construct(StoreRepository $store)
    {
        $this->store = $store;
    }

    public function index(Request $request)
    {
        try {
            //Request to Repository
            $stores = $this->store->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => StoreTransformer::collection($stores)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($stores)] : false;

        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage()
            ];
        }
        return response()->json($response, $status ?? 200);
    }


    public function show($criteria, Request $request)
    {
        try {
            //Request to Repository
            $store = $this->store->getItem($criteria,$this->getParamsRequest($request));

            $response = [
                'data' => $store ? new StoreTransformer($store) : '',
            ];

        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage()
            ];
        }
        return response()->json($response, $status ?? 200);
    }


    public function create(Request $request)
    {
      \DB::beginTransaction();
      try {
        $data = $request->input('attributes') ?? [];//Get data

        //Validate Request
        $this->validateRequestApi(new StoreRequest($data));

        //Create item
        $product = $this->store->create($data);

        //Response
        $response = ["data" => new StoreTransformer($product)];
        \DB::commit(); //Commit to Data Base
      } catch (\Exception $e) {
        \Log::error($e);
        \DB::rollback();//Rollback to Data Base
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }
      //Return response
      return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    public function update($criteria, Request $request)
    {
      \DB::beginTransaction(); //DB Transaction
      try {
        //Get data
        $data = $request->input('attributes') ?? [];//Get data

        //Get Parameters from URL.
        $params = $this->getParamsRequest($request);

        $dataEntity = $this->store->getItem($criteria, $params);

        if (!$dataEntity) throw new Exception('Item not found', 204);

        //Request to Repository
        $this->store->update($dataEntity, $data);
        //Response
        $response = ["data" => 'Item Updated'];
        \DB::commit();//Commit to DataBase
      } catch (\Exception $e) {
        \Log::error($e);
        \DB::rollback();//Rollback to Data Base
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }

      //Return response
      return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    public function delete($criteria, Request $request)
    {
      \DB::beginTransaction();
      try {
        //Get params
        $params = $this->getParamsRequest($request);


        $dataEntity = $this->store->getItem($criteria, $params);

        if (!$dataEntity) throw new Exception('Item not found', 204);

        //call Method delete
        $this->store->destroy($dataEntity);

        //Response
        $response = ["data" => "Item deleted"];
        \DB::commit();//Commit to Data Base
      } catch (\Exception $e) {
        \Log::error($e);
        \DB::rollback();//Rollback to Data Base
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }

      //Return response
      return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

}
