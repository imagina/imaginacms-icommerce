<?php

namespace Modules\Icommerce\Http\Controllers\Api;

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


class CartProductApiController extends BaseApiController
{
  private $cartProduct;

  public function __construct(CartProductRepository $cartProduct)
  {
    $this->cartProduct = $cartProduct;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $cartProducts = $this->cartProduct->index($this->getParamsRequest());

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
      $cartProduct = $this->cartProduct->show($id,$this->getParamsRequest());

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
  public function create(CartProductRequest $request)
  {
    try {
      $this->cartProduct->create($request->all());

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
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update($criteria, CartProductRequest $request)
  {
    try {
      $this->cartProduct->updateBy($criteria, $request->all(),$this->getParamsRequest());

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
      $this->cartProduct->deleteBy($criteria,$this->getParamsRequest());

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
