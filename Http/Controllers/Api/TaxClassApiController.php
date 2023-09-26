<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Requests\TaxClassRequest;
// Base Api
use Modules\Icommerce\Repositories\TaxClassRepository;
// Transformers
use Modules\Icommerce\Transformers\TaxClassTransformer;
// Entities

// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class TaxClassApiController extends BaseApiController
{
    private $taxClass;

    public function __construct(TaxClassRepository $taxClass)
    {
        $this->taxClass = $taxClass;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //Request to Repository
            $taxClasses = $this->taxClass->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => TaxClassTransformer::collection($taxClasses)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($taxClasses)] : false;
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /** SHOW
     * @param  Request  $request
     *  URL GET:
     *  &fields = type string
     *  &include = type string
     */
    public function show($criteria, Request $request)
    {
        try {
            //Request to Repository
            $taxClass = $this->taxClass->getItem($criteria, $this->getParamsRequest($request));

            $response = [
                'data' => $taxClass ? new TaxClassTransformer($taxClass) : '',
            ];
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $data = $request->input('attributes') ?? []; //Get data
            $this->validateRequestApi(new TaxClassRequest($data));
            $taxClass = $this->taxClass->create($data);

            $response = ['data' => $taxClass];
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage().' '.$e->getFile().' '.$e->getLine(),
                'trace' => $e->getTrace(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
      //Get data
            $data = $request->input('attributes') ?? []; //Get data

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            $dataEntity = $this->taxClass->getItem($criteria, $params);

            if (! $dataEntity) {
                throw new \Exception('Item not found', 204);
            }

            //Request to Repository
            $this->taxClass->updateBy($criteria, $data, $params);
            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($criteria, Request $request)
    {
        try {
            $this->taxClass->deleteBy($criteria, $this->getParamsRequest($request));

            $response = ['data' => ''];
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
