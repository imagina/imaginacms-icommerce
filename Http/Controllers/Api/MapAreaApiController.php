<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Entities
use Modules\Icommerce\Entities\MapArea;

// Repositories
use Modules\Icommerce\Repositories\MapAreaRepository;

// Requests & Response
use Modules\Icommerce\Http\Requests\MapAreaRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Transformers
use Modules\Icommerce\Transformers\MapAreaTransformer;


class MapAreaApiController extends BaseApiController
{
    private $mapArea;

    public function __construct(MapAreaRepository $mapArea)
    {
        $this->mapArea = $mapArea;
    }


    public function index(Request $request)
    {
        try {
            //Request to Repository
            $mapAreas = $this->mapArea->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => MapAreaTransformer::collection($mapAreas)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($mapAreas)] : false;

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
            $mapArea = $this->mapArea->getItem($criteria,$this->getParamsRequest($request));

            $response = [
                'data' => $mapArea ? new MapAreaTransformer($mapArea) : '',
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
            $this->mapArea->create($request->all());

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
            $this->mapArea->updateBy($criteria, $request->all(),$this->getParamsRequest($request));

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

            $this->mapArea->deleteBy($criteria,$this->getParamsRequest($request));

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
