<?php

namespace Modules\Icommerce\Http\Controllers\Api;

//Auth
use Modules\Icommerce\Repositories\CartRepository;
use Modules\User\Contracts\Authentication;
// Requests & Response
use Modules\Icommerce\Http\Requests\CartProductRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\CartProductTransformer;

// Entities
use Modules\Icommerce\Entities\CartProduct;

// Repositories
use Modules\Icommerce\Repositories\CartProductRepository;

//Transactions
use DB;

class CartProductApiController extends BaseApiController
{
  private $cartProduct;
  private $cart;
  protected $auth;
  
  public function __construct(CartProductRepository $cartProduct, CartRepository $cart)
  {
    $this->cartProduct = $cartProduct;
    $this->cart = $cart;
    $this->auth = app(Authentication::class);
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
      $dataEntity = $this->cartProduct->getItemsBy($params);
      
      //Response
      $response = [
        "data" => CartProductTransformer::collection($dataEntity)
      ];
      
      //If request pagination add meta-page
      $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
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
      $dataEntity = $this->cartProduct->getItem($criteria, $params);
      
      //Break if no found item
      if (!$dataEntity) throw new \Exception('Item not found', 404);
      
      //Response
      $response = ["data" => new CartProductTransformer($dataEntity)];
      
    } catch (\Exception $e) {
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
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
      $this->validateRequestApi(new CartProductRequest((array)$data));

      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
        //If user autenticated
        //Validate if cart belongs to user autenticated
        $cart = $this->cart->findByAttributes(['id' => $data['cart_id']]);
        if ($cart) {
            //Create Product Api
            $cartProduct = $this->cartProduct->findByAttributes(['cart_id' => $data['cart_id'],'product_id' => $data['product_id']]);

            if(!$cartProduct)
                $this->cartProduct->create($data);
            else
              $this->cartProduct->updateBy($cartProduct->id,$data,$params);

        } else
          throw new \Exception("This cart id doesn't exist", 403);
      


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
      $this->validateRequestApi(new CartProductRequest((array)$data));
      
      //Get Parameters from URL.
      $params = $this->getParamsRequest($request);
      
      //Request to Repository
      $this->cartProduct->updateBy($criteria, $data, $params);
      
      //Response
      $response = ["data" => 'Item Updated'];
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
      $this->cartProduct->deleteBy($criteria, $params);
      
      //Response
      $response = ["data" => ""];
      \DB::commit();//Commit to Data Base
    } catch (\Exception $e) {
      \DB::rollback();//Rollback to Data Base
      $status = $this->getStatusError($e->getCode());
      $response = ["errors" => $e->getMessage()];
    }
    
    //Return response
    return response()->json($response, $status ?? 200);
  }
  
}
