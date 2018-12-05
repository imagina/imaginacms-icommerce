<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\OptionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\OptionTransformer;

// Repositories
use Modules\Icommerce\Repositories\OptionRepository;

class OptionApiController extends BaseApiController
{
  private $option;
  
  public function __construct(
    OptionRepository $option)
  {
    $this->option = $option;
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
      $options = $this->option->index($p->page, $p->take, $p->filter, $p->include, $p->fields);
      
      //Response
      $response = ["data" => OptionTransformer::collection($options)];
      //If request pagination add meta-page
      $p->page ? $response["meta"] = ["page" => $this->pageTransformer($options)] : false;
      
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
  public function show($id, Request $request)
  {
    try {
      //Get Parameters from URL.
      $p = $this->parametersUrl(false, false, [], []);
      
      //Request to Repository
      $option = $this->option->show($p->filter, $p->include, $p->fields, $id);
      
      $response = [
        "data" => $option ? new OptionTransformer($option) : "",
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
  public function create(OptionRequest $request)
  {
    try {
      $this->option->create($request->all());
      
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
  public function update($id, OptionRequest $request)
  {
    try {
      $option = $this->option->find($id);
      $this->option->update($option, $request->all());
      
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
      $option = $this->option->find($id);
      $option->delete();
      
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
