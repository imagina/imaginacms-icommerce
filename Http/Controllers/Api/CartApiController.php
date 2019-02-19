<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\CartRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Requests\CartProductRequest;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\CartTransformer;

// Entities
use Modules\Icommerce\Entities\Cart;

//Auth
use Modules\User\Contracts\Authentication;

// Repositories
use Modules\Icommerce\Repositories\CartRepository;
//Transactions
use DB;
class CartApiController extends BaseApiController
{
  private $cart;
  protected $auth;

  public function __construct(CartRepository $cart)
  {
    $this->cart = $cart;
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
      $carts = $this->cart->getItemsBy($this->getParamsRequest($request));

      //Response
      $response = ['data' => CartTransformer::collection($carts)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($carts)] : false;

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
      $cart = $this->cart->getItem($id, $this->getParamsRequest($request));

      $response = [
        'data' => $cart ? new CartTransformer($cart) : '',
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
   * Create a new resource.
   * @return Response
   */
   public function create(Request $request)
   {
     try {
       DB::beginTransaction();
       //Validate Request
       $request['ip']=$request->ip();
       $this->validateRequestApi(new CartRequest($request->all()));

       $cart = $this->cart->create($request->all());

       DB::commit();
       $response = ['data' => ['cart'=> new CartTransformer($cart)]];
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
      $this->cart->updateBy($criteria, $request->all(),$this->getParamsRequest($request));

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
      $this->cart->deleteBy($criteria,$this->getParamsRequest($request));

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
