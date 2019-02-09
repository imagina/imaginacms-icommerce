<?php

namespace Modules\Icommerce\Http\Controllers\Api;
//Auth
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
  protected $auth;

  public function __construct(CartProductRepository $cartProduct)
  {
    $this->cartProduct = $cartProduct;
    $this->auth = app(Authentication::class);
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $cartProducts = $this->cartProduct->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => CartProductTransformer::collection($cartProducts)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($cartProducts)] : false;

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
  public function show($id, Request $request)
  {
    try {
      //Request to Repository
      $cartProduct = $this->cartProduct->getItem($id,$this->getParamsRequest($request));

      $response = [
        'data' => $cartProduct ? new CartProductTransformer($cartProduct) : '',
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
     try {
       DB::beginTransaction();
       //Validate Request
       $this->validateRequestApi(new CartProductRequest($request->all()));
       //Get user autenticated
       $user=Auth::guard('api')->user();
       if($user){
         //If user autenticated
         //Validate if cart belongs to user autenticated
         $cart=Cart::where('id',$request->cart_id)->where('user_id',$user->id)->first();
         if($cart){
           //Create Product Api
           $this->cartProduct->create($request->all());
         }else
         throw new \Exception("This cart id doesn't belongs to user autenticated",404);
       }else
         $this->cartProduct->create($request->all());
       DB::commit();
       $response = ['data' => ''];
     } catch (\Exception $e) {
       DB::rollBack();
       $status = 500;
       $response = [
         'errors' => $e->getMessage()
       ];
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
      $this->cartProduct->updateBy($criteria, $request->all(),$this->getParamsRequest($request));

      $response = ['data' => ''];

    } catch (\Exception $e) {
      $status = 500;
      $response = [
        'errors' => $e->getMessage()
      ];
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
      $this->cartProduct->deleteBy($criteria,$this->getParamsRequest($request));

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
