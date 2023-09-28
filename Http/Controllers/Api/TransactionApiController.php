<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Icommerce\Repositories\TransactionRepository;
// Transformers
use Modules\Icommerce\Transformers\TransactionTransformer;
// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class TransactionApiController extends BaseApiController
{
    private $transaction;

    public function __construct(TransactionRepository $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //Request to Repository
            $transactions = $this->transaction->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => TransactionTransformer::collection($transactions)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($transactions)] : false;
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
            //Get Parameters from URL.
            $p = $this->parametersUrl(false, false, [], []);

            //Request to Repository
            $transaction = $this->transaction->getItem($criteria, $this->getParamsRequest($request));

            $response = [
                'data' => $transaction ? new TransactionTransformer($transaction) : '',
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
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            //Create item
            $transaction = $this->transaction->create($data);

            //Response
            $response = ['data' => $transaction];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $this->getErrorMessage($e)];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($criteria, Request $request)
    {
        try {
            $data = $this->transaction->updateBy($criteria, $request->all(), $this->getParamsRequest($request));

            $response = ['data' => $data];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($criteria, Request $request)
    {
        try {
            $this->transaction->deleteBy($criteria, $this->getParamsRequest($request));

            $response = ['data' => ''];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
