<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Requests\CurrencyRequest;
// Base Api
use Modules\Icommerce\Repositories\CurrencyRepository;
// Transformers
use Modules\Icommerce\Transformers\CurrencyTransformer;
// Entities

// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class CurrencyApiController extends BaseApiController
{
    private $currency;

    public function __construct(CurrencyRepository $currency)
    {
        $this->currency = $currency;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //Request to Repository
            $currencies = $this->currency->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => CurrencyTransformer::collection($currencies)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($currencies)] : false;
        } catch (\Exception $e) {
            //Message Error
            \Log::error($e->getMessage());
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
            $currency = $this->currency->getItem($criteria, $this->getParamsRequest($request));

            $response = [
                'data' => $currency ? new CurrencyTransformer($currency) : '',
            ];
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
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();

        try {
            //Get data
            $data = $request['attributes'] ?? [];

            //Validate Request
            $this->validateRequestApi(new CurrencyRequest($data));

            $currency = $this->currency->create($data);

            $response = ['data' => new CurrencyTransformer($currency)];

            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }

        /**
         * UPDATE ITEM
         *
         * @return mixed
         */
        public function update($criteria, Request $request)
        {
            \DB::beginTransaction(); //DB Transaction
            try {
                //Get data
                $data = $request->input('attributes');

                //Validate Request
                //$this->validateRequestApi(new CurrencyRequest((array)$data));

                //Get Parameters from URL.
                $params = $this->getParamsRequest($request);

                //Request to Repository
                $currency = $this->currency->updateBy($criteria, $data, $params);

                //Response
                $response = ['data' => new CurrencyTransformer($currency)];
                \DB::commit(); //Commit to DataBase
            } catch (\Exception $e) {
                \DB::rollback(); //Rollback to Data Base
                $status = $this->getStatusError($e->getCode());
                $response = ['errors' => $e->getMessage()];
            }

            //Return response
            return response()->json($response, $status ?? 200);
        }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($criteria, Request $request)
    {
        try {
            \DB::beginTransaction();

            $params = $this->getParamsRequest($request);

            $this->currency->deleteBy($criteria, $params);

            $response = ['data' => ''];

            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }
}
