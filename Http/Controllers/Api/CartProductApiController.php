<?php

namespace Modules\Icommerce\Http\Controllers\Api;

//Auth
use DB;
use Illuminate\Http\Request;
// Requests & Response
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Requests\CartProductRequest;
use Modules\Icommerce\Repositories\CartProductRepository;
// Base Api
use Modules\Icommerce\Repositories\CartRepository;
// Transformers
use Modules\Icommerce\Transformers\CartProductTransformer;
// Repositories
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
//Transactions
use Modules\User\Contracts\Authentication;

class CartProductApiController extends BaseApiController
{
    private $cartProduct;

    private $cart;

    protected $auth;

    public function __construct(CartProductRepository $cartProduct, CartRepository $cart)
    {
        $this->cartProduct = $cartProduct;
        $this->cart = $cart;
        $this->auth = app(Authentication::class);
    }

    /**
     * GET ITEMS
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $dataEntity = $this->cartProduct->getItemsBy($params);

            //Response
            $response = [
                'data' => CartProductTransformer::collection($dataEntity),
            ];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $dataEntity = $this->cartProduct->getItem($criteria, $params);

            //Break if no found item
            if (! $dataEntity) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new CartProductTransformer($dataEntity)];
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            // validate if quantity is <= 0
            if (intval($data['quantity']) <= 0) {
                throw new \Exception('There some errors in data', 400);
            }

            //Validate Request
            $this->validateRequestApi(new CartProductRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            // find cart by attributes
            $cart = $this->cart->findByAttributes(['id' => $data['cart_id']]);

            if ($cart) {
                $this->cartProduct->create($data);
            } else {
                throw new \Exception("This cart id doesn't exist", 400);
            }

            //Response
            $response = ['data' => ''];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes');

            //TODO ARREGLAR ESTA CHAMBONADA ALGUN DIA
            // validate if quantity is <= 0
            if (intval($data['quantity']) <= 0) {
                throw new \Exception('There some errors in data', 400);
            }

            //Validate Request
            $this->validateRequestApi(new CartProductRequest((array) $data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $result = $this->cartProduct->updateBy($criteria, $data, $params);

            //Response
            $response = ['data' => 'Item Updated'];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * DELETE A ITEM
     *
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //call Method delete
            $this->cartProduct->deleteBy($criteria, $params);

            //Response
            $response = ['data' => ''];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }
}
