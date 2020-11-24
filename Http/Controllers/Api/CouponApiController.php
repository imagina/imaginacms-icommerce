<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\CouponRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

// Transformers
use Modules\Icommerce\Transformers\CouponTransformer;

// Entities
use Modules\Icommerce\Entities\Coupon;

// Repositories
use Modules\Icommerce\Repositories\CouponRepository;

// Support
use Modules\Icommerce\Support\validateCoupons;

class CouponApiController extends BaseApiController
{
    private $coupon;

    public function __construct(CouponRepository $coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index(Request $request)
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
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            if (isset($params->filter->validate) && $params->filter->validate) {
                if (isset($params->filter->cart) || $params->filter->store) {
                    $validateCoupon = new validateCoupons();
                    $data = $validateCoupon->validateCode($criteria, $params->filter->cart, $params->filter->store);

                    $response = ["data" => $data];

                } else {
                    $response = ["data" => ['message' => trasn('icommerce::coupons.messages.coupon not exist'),'status'=>0,'discount'=>0]];
                }


            } else {

                //Request to Repository
                $coupon = $this->coupon->getItem($criteria, $params);

                //Break if no found item
                if (!$coupon) throw new Exception('Item not found', 404);

                //Response
                $response = ["data" => new CouponTransformer($coupon)];
            }
        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CouponRequest($data));

            //Create item
            $coupon = $this->coupon->create($data);

            //Response
            $response = ["data" => new CouponTransformer($coupon)];

            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Response
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $data = $request->input('attributes');
            //Validate Request
            $this->validateRequestApi(new CouponRequest($data));
            //Update data
            //Request to Repository
            $entity = $this->coupon->getItem($criteria, $params);

            //Break if no found item
            if (!$entity) throw new Exception('Item not found', 404);

            $coupon = $this->coupon->update($entity, $data);
            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            $params = $this->getParamsRequest($request);
            $data = $request->input('attributes');
            //Validate Request
            $this->validateRequestApi(new CouponRequest($data));
            //Update data
            //Request to Repository
            $entity = $this->coupon->getItem($criteria, $params);

            //Break if no found item
            if (!$entity) throw new Exception('Item not found', 404);

            $coupon = $this->coupon->destroy($entity);
            //Response
            $response = ['data' => 'Item Deleted'];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response, $status ?? 200);
    }

    public function validateCoupon(Request $request)
    {
        try {
            $params = $this->getParamsRequest($request);
            $validateCoupons = new validateCoupons();
            $response = $validateCoupons->validateCode($params->filter->couponCode, $params->filter->cartId);
        } catch (\Exception $exception) {
          \Log::error($exception->getMessage());
            $status = 500;
            $response = [
                'errors' => $exception->getMessage()
            ];
        }
        return response()->json($response, $status ?? 200);
    }

}
