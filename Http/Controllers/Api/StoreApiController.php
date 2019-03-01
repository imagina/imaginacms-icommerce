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
        try {
            $this->store->create($request->all());

            $response = ['data' => ''];

        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage()
            ];
        }
        return response()->json($response, $status ?? 200);
    }

    public function update($criteria, Request $request)
    {
        try {
            $this->store->updateBy($criteria, $request->all(),$this->getParamsRequest($request));

            $response = ['data' => ''];

        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage()
            ];
        }
        return response()->json($response, $status ?? 200);
    }

    public function delete($criteria, Request $request)
    {
        try {

            $this->store->deleteBy($criteria,$this->getParamsRequest($request));

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
