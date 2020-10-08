<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\PaymentMethodRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\PaymentMethodTransformer;

// Entities
use Modules\Icommerce\Entities\PaymentMethod;

// Repositories
use Modules\Icommerce\Repositories\PaymentMethodRepository;

class PaymentMethodApiController extends BaseApiController
{
  private $paymentMethod;

  public function __construct(PaymentMethodRepository $paymentMethod)
  {
    $this->paymentMethod = $paymentMethod;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $paymentMethods = $this->paymentMethod->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => PaymentMethodTransformer::collection($paymentMethods)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($paymentMethods)] : false;

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
      $paymentMethod = $this->paymentMethod->getItem($criteria, $this->getParamsRequest($request));

      $response = [
        'data' => $paymentMethod ? new PaymentMethodTransformer($paymentMethod) : '',
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
       * CREATE A ITEM
       *
       * @param Request $request
       * @return mixed
       */
      public function create(Request $request)
      {
        \DB::beginTransaction();
        try {
         //Get data
          $data = $request->input('attributes');

          //Validate Request
          //$this->validateRequestApi(new CustomRequest((array)$data));

          //Create item
          $this->paymentMethod->create($data);

          //Response
          $response = ["data" => ""];
          \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
          \DB::rollback();//Rollback to Data Base
          $status = $this->getStatusError($e->getCode());
          $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
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
          $data = $request->input('attributes');
          //Validate Request
          //$this->validateRequestApi(new CustomRequest((array)$data));

          //Get Parameters from URL.
          $params = $this->getParamsRequest($request);
          $entity = $this->paymentMethod->getItem($criteria, $params);


          //Request to Repository
          $result = $this->paymentMethod->update($entity, $data);
        //Response
        $response = ["data" => $result->id];
        \DB::commit();//Commit to DataBase
      } catch (\Exception $e) {
        \DB::rollback();//Rollback to Data Base
        $status = $this->getStatusError($e->getCode());
        $response = ["errors" => $e->getMessage()];
      }

      //Return response
      return response()->json($response, $status ?? 200);
    }


  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function delete($criteria, Request $request)
  {
    try {

        $params = $this->getParamsRequest($request);
        $entity = $this->paymentMethod->getItem($criteria, $params);
        $this->paymentMethod->delete($entity);

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
