<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\ProductTransformer;

// Entities
use Modules\Icommerce\Entities\Tag;
use Modules\Icommerce\Entities\Product;

// Repositories
use Modules\Icommerce\Repositories\ProductRepository;

class ProductApiController extends BaseApiController
{
  private $product;

  public function __construct(ProductRepository $product)
  {
    $this->product = $product;
  }

  /**
   * Get List Products
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $products = $this->product->getItemsBy($params);

      //Response
      $response = ['data' => ProductTransformer::collection($products)];

      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($products)] : false;
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
      $product = $this->product->getItem($criteria, $params);

      //Break if no found item
      if (!$product) throw new \Exception('Item not found', 204);

      //Response
      $response = ["data" => new ProductTransformer($product)];

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
      $this->validateRequestApi(new ProductRequest($data));

      //Create item
      $product = $this->product->create($data);

      //Response
      $response = ["data" => new ProductTransformer($product)];
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

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);

      //Request to Repository
      $this->product->updateBy($criteria, $data, $params);

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

      //call Method delete
      $this->product->deleteBy($criteria, $params);

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

  /**
   * Add tags Product
   *
   * @param  Array tags ids
   * @return Array
   */
  public function addTags($tags)
  {

    $tags = $tags;
    $newtags = Array();
    $lasttagsid = Array();
    $newtagsid = Array();

    if (!empty($tags)) {

      //se recorren todos lostags en busca de alguno nuevo
      foreach ($tags as $tag) {
        //si el tag no existe se agrega al array de de nuevos tags
        if (count(Tag::find($tag)) <= 0) {
          array_push($newtags, $tag);
        } else {
          //si el tag existe se agrega en un array de viejos tags
          array_push($lasttagsid, $tag);
        }
      }
    }
    //se crean todos los tags que no existian
    foreach ($newtags as $newtag) {
      $modeltag = new Tag;
      $modeltag->title = $newtag;
      $modeltag->slug = str_slug($newtag, '-');
      $modeltag->save();

      array_push($newtagsid, $modeltag->id);
    }

    //se modifica el valor tags enviado desde el form uniendolos visjos tags y los tags nuevos
    return array_merge($lasttagsid, $newtagsid);

  }
}
