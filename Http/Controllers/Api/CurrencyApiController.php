<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\CurrencyRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\CurrencyTransformer;

// Entities
use Modules\Icommerce\Entities\Currency;

// Repositories
use Modules\Icommerce\Repositories\CurrencyRepository;

class CurrencyApiController extends BaseApiController
{
  private $currency;

  public function __construct(CurrencyRepository $currency)
  {
    $this->currency = $currency;
  }

  /**
   * Display a listing of the resource.
   * @return Response
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
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }

  /** SHOW
   * @param Request $request
   *  URL GET:
   *  &fields = type string
   *  &include = type string
   */
  public function show($criteria, Request $request)
  {
    try {
      //Request to Repository
      $currency = $this->currency->getItem($criteria,$this->getParamsRequest($request));

      $response = [
        'data' => $currency ? new CurrencyTransformer($currency) : '',
      ];

    } catch (\Exception $e) {
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }

  /**
   * Show the form for creating a new resource.
   * @return Response
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
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];

    }
    return response()->json($response, $status ?? 200);
  }

  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update($criteria, Request $request)
  {
    try {

      \DB::beginTransaction();

      $params = $this->getParamsRequest($request);

      $data = $request->all();

      //Validate Request
      $this->validateRequestApi(new CurrencyRequest($data));
      
      $currency = $this->currency->updateBy($criteria, $data,$params);

      $response = ['data' => new CurrencyTransformer($currency)];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

      \Log::error($e->getMessage());
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];

    }
    return response()->json($response, $status ?? 200);
  }

  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function delete($criteria, Request $request)
  {
    try {

      \DB::beginTransaction();

      $params = $this->getParamsRequest($request);

      $this->currency->deleteBy($criteria,$params);

      $response = ['data' => ''];

      \DB::commit(); //Commit to Data Base

    } catch (\Exception $e) {

      \Log::error($e->getMessage());
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
      
    }
    return response()->json($response, $status ?? 200);
  }
}
