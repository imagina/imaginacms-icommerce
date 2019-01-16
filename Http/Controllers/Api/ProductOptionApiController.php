<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\ProductOptionTransformer;

// Repositories
use Modules\Icommerce\Repositories\ProductOptionRepository;

class ProductOptionApiController extends BaseApiController
{

    private $productOption;


    public function __construct(ProductOptionRepository $productOption)
    {
        $this->productOption = $productOption;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            //Request to Repository
            $productOptions = $this->productOption->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => ProductOptionTransformer::collection($productOptions)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($productOptions)] : false;

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
            $productOption = $this->productOption->getItem($criteria,$this->getParamsRequest($request));

            $response = [
                'data' => $productOption ? new ProductOptionTransformer($productOption) : '',
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
            $data = $this->productOption->create($request->all());

            $response = ['data' => $data];

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
    public function update($criteria, Request $request)
    {
        try {

            $this->productOption->updateBy($criteria, $request->all(), $this->getParamsRequest($request));

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

            $this->productOption->deleteBy($criteria, $this->getParamsRequest($request));

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
