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

// Repositories
use Modules\Icommerce\Repositories\ProductRepository;


class ProductApiController extends BaseApiController
{
  
  private $product;
  
  
  public function __construct(
    ProductRepository $product)
  {
    $this->product = $product;
  }
  
  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index()
  {
    try {
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, ["status" => [1]], []);
      
      //Request to Repository
      $products = $this->product->index($p->page, $p->take, $p->filter, $p->include, $p->fields);
      
      //Response
      $response = ["data" => ProductTransformer::collection($products)];
      //If request pagination add meta-page
      $p->page ? $response["meta"] = ["page" => $this->pageTransformer($products)] : false;
      
    } catch (\Exception $e) {
      //Message Error
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
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
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, [], []);
      
      //Request to Repository
      $product = $this->product->show($p->filter, $p->include, $p->fields, $criteria);
      
      $response = [
        "data" => $product ? new ProductTransformer($product) : "",
      ];
      
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
  
  /**
   * Show the form for creating a new resource.
   * @return Response
   */
  public function create(ProductRequest $request)
  {
    try {
      $product = $this->product->create($request->all());
  
      // sync tables
      if ($product){
        // Product Options
        if (isset($request->options))
          $product->options()->sync($request->options);
  
        // Product Option Values
        if (isset($request->optionValues))
          $product->optionValues()->sync($request->optionValues);
  
        // Related Products
        if (isset($request->relatedProducts))
          $product->relatedProducts()->sync($request->relatedProducts);
  
        // Discounts
        if (isset($request->discounts))
          $product->discounts()->sync($request->discounts);
  
      }
      
      $response = ["data" => ""];
      
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
  
  /**
   * Update the specified resource in storage.
   * @param  Request $request
   * @return Response
   */
  public function update($id, ProductRequest $request)
  {
    try {
      
      $product = $this->product->find($id);
      $product = $this->product->update($product, $request->all());
  
      // sync tables
      if ($product){
        // Product Options
        if (isset($request->options))
          $product->options()->sync($request->options);
    
        // Product Option Values
        if (isset($request->optionValues))
          $product->optionValues()->sync($request->optionValues);
    
        // Related Products
        if (isset($request->relatedProducts))
          $product->relatedProducts()->sync($request->relatedProducts);
    
        // Discounts
        if (isset($request->discounts))
          $product->discounts()->sync($request->discounts);
    
      }
      
      $response = ["data" => ""];
      
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
  
  
  /**
   * Remove the specified resource from storage.
   * @return Response
   */
  public function delete($id, Request $request)
  {
    try {
      $product = $this->product->find($id);
      $product->delete();
      
      $response = ["data" => ""];
      
    } catch (\Exception $e) {
      $status = 400;
      $response = [
        "errors" => $e->getMessage()
      ];
    }
    return response()->json($response, $status ?? 200);
  }
}
