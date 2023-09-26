<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// Base Api
use Modules\Icommerce\Repositories\OrderHistoryRepository;
// Transformers
use Modules\Icommerce\Transformers\OrderHistoryTransformer;
// Entities

// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class OrderStatusHistoryApiController extends BaseApiController
{
    private $orderHistory;

    public function __construct(OrderHistoryRepository $orderHistory)
    {
        $this->orderHistory = $orderHistory;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.

            //Request to Repository
            $orderHistories = $this->orderHistory->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => OrderHistoryTransformer::collection($orderHistories)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($orderHistories)] : false;
        } catch (\Exception $e) {
            //Message Error
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /** SHOW
     * @param  Request  $request
     *  URL GET:
     *  &fields = type string
     *  &include = type string
     */
    public function show($criteria, Request $request)
    {
        try {
            //Request to Repository
            $orderHistory = $this->orderHistory->getItem($criteria, $this->getParamsRequest($request));

            $response = [
                'data' => $orderHistory ? new OrderHistoryTransformer($orderHistory) : '',
            ];
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            $data = $request->input('attributes');

            $orderHistory = $this->orderHistory->create($data);

            $response = ['data' => $orderHistory];
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($criteria, Request $request)
    {
        try {
            $this->orderHistory->updateBy($criteria, $request->all(), $this->getParamsRequest($request));

            $response = ['data' => ''];
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($criteria, Request $request)
    {
        try {
            $this->orderHistory->deleteBy($criteria, $this->getParamsRequest($request));

            $response = ['data' => ''];
        } catch (\Exception $e) {
            $status = 500;
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
