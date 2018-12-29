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

// Entities
use Modules\Icommerce\Entities\Option;

// Repositories
use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Icommerce\Repositories\OptionValueRepository;

class OptionApiController extends BaseApiController
{
  private $option;
  private $optionValue;

  public function __construct(OptionRepository $option, OptionValueRepository $optionValue)
  {
    $this->option = $option;
    $this->optionValue = $optionValue;
  }

  /**
   * Display a listing of the resource.
   * @return Response
   */
  public function index(Request $request)
  {
    try {
      //Request to Repository
      $options = $this->option->index($this->getParamsRequest());

      //Response
      $response = ['data' => OptionTransformer::collection($options)];
      //If request pagination add meta-page
      $request->page ? $response['meta'] = ['page' => $this->pageTransformer($options)] : false;

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
      $option = $this->option->show($criteria,$this->getParamsRequest());

      $response = [
        'data' => $option ? new OptionTransformer($option) : '',
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
  public function create(OptionRequest $request)
  {
    \DB::beginTransaction();
    try {
      $option = $this->option->create($request->all());

      foreach ($request->optionValues as $optionValue){
        $optionValue["option_id"] = $option->id;
        $this->optionValue->create($optionValue);
      }

      $response = ['data' => ''];
      \DB::commit();

    } catch (\Exception $e) {
      \DB::rollback();
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
  public function update($criteria, OptionRequest $request)
  {
    try {
      $option = $this->option->updateBy($criteria, $request->all(),$this->getParamsRequest());

      foreach ($request->optionValues as $optionValue)
        if(isset($optionValue['id']) && !empty($optionValue['id']))
          $this->optionValue->updateBy($optionValue['id'],$optionValue,$this->getParamsRequest());
        else{
          $optionValue["option_id"] = $option->id;
          $this->optionValue->create($optionValue);
        }


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
      $this->option->deleteBy($criteria,$this->getParamsRequest());

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
