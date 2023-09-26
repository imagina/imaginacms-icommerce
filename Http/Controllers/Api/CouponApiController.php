<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Entities\Coupon;
// Base Api
use Modules\Icommerce\Http\Requests\CouponRequest;
// Transformers
use Modules\Icommerce\Repositories\CouponRepository;
// Entities
use Modules\Icommerce\Transformers\CouponTransformer;
// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Support

class CouponApiController extends BaseApiController
{
    private $coupon;

    public function __construct(CouponRepository $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        try {
            //Request to Repository
            $coupons = $this->coupon->getItemsBy($this->getParamsRequest($request));

            //Response
            $response = ['data' => CouponTransformer::collection($coupons)];
            //If request pagination add meta-page
            $request->page ? $response['meta'] = ['page' => $this->pageTransformer($coupons)] : false;
        } catch (\Exception $e) {
            //Message Error
            \Log::error($e->getMessage());
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
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $coupon = $this->coupon->getItem($criteria, $params);

            //Break if no found item
            if (! $coupon) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new CouponTransformer($coupon)];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): Response
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? []; //Get data

            //Validate Request
            $this->validateRequestApi(new CouponRequest($data));

            //Create item
            $coupon = $this->coupon->create($data);

            //Response
            $response = ['data' => new CouponTransformer($coupon)];

            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($criteria, Request $request): Response
    {
        \DB::beginTransaction();

        try {
            $params = $this->getParamsRequest($request);

            $data = $request->input('attributes') ?? [];

            //Validate Request
            $this->validateRequestApi(new CouponRequest($data));

            //Update data
            //Request to Repository
            $entity = $this->coupon->getItem($criteria, $params);

            //Break if no found item
            if (! $entity) {
                throw new \Exception('Item not found', 404);
            }

            $coupon = $this->coupon->update($entity, $data);
            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($criteria, Request $request): Response
    {
        \DB::beginTransaction();

        try {
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $entity = $this->coupon->getItem($criteria, $params);

            //Break if no found item
            if (! $entity) {
                throw new \Exception('Item not found', 404);
            }

            $coupon = $this->coupon->destroy($entity);
            //Response
            $response = ['data' => 'Item Deleted'];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response, $status ?? 200);
    }

    /**
     * Validate Coupon.
     */
    public function validateCoupon(Request $request): Response
    {
        try {
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $coupon = $this->coupon->validateCoupon($params);

            //Break if no found item
            if (! $coupon) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new CouponTransformer($coupon)];
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            $status = 500;
            $response = [
                'errors' => $exception->getMessage(),
            ];
        }

        return response()->json($response, $status ?? 200);
    }
}
