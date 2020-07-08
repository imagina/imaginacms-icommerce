<?php

namespace Modules\Icommerce\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\ProductDiscountTransformer;

// Repositories
use Modules\Icommerce\Repositories\ProductDiscountRepository;



class ProductDiscountApiController extends BaseApiController
{
  private $productDiscount;


  public function __construct(ProductDiscountRepository $productDiscount/*, ProductOptionOrdener $productDiscountOrdener*/)
  {
    $this->productDiscount = $productDiscount;

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
      $productDiscounts = $this->productDiscount->getItemsBy($params);

      //Response
      $response = ["data" => ProductDiscountTransformer::collection($productDiscounts)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($productDiscounts)] : false;
    } catch (\Exception $e) {
        \Log::error($e);
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
      $productDiscount = $this->productDiscount->getItem($criteria, $params);

      //Break if no found item
      if (!$productDiscount) throw new \Exception('Item not found', 204);

      //Response
      $response = ["data" => new ProductDiscountTransformer($productDiscount)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($productDiscount)] : false;
    } catch (\Exception $e) {
        \Log::error($e);
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

      //Create item
      $productDiscount = $this->productDiscount->create($data);

      //Response
      $response = ["data" => ''];
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

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $this->productDiscount->updateBy($criteria, $data, $params);

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

      //call Method delete
      $this->productDiscount->deleteBy($criteria, $params);

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



  /*public function updateOrder (Request $request)
  {
    try {
      $data = $request->input('attributes');
      $response = [
        'data' => $this->productDiscountOrdener->handle($data['options'])
      ];
      $status = 200;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status);

  }*/

}
