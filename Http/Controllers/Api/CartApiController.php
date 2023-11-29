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
            $dataEntity = $this->cart->getItemsBy($params);

            //Response
            $response = [
                "data" => CartTransformer::collection($dataEntity)
            ];

            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * GET A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function show($criteria, Request $request)
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $dataEntity = $this->cart->getItem($criteria, $params);

            //Break if no found item
            if (!$dataEntity) throw new \Exception('Item not found', 404);

            //Response
            $response = ["data" => new CartTransformer($dataEntity)];

        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * CREATE A ITEM
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CartRequest((array)$data));

            $data["ip"] = $request->ip();
            $data["session_id"] = session('key');
            
            //Create item
            $cart = $this->cart->create($data);

            //Response
            $response = ["data" =>  new CartTransformer($cart)];
            \DB::commit(); //Commit to Data Base
        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * UPDATE ITEM
     *
     * @param $criteria
     * @param Request $request
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes');

            //Validate Request
            $this->validateRequestApi(new CartRequest((array)$data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $this->cart->updateBy($criteria, $data, $params);

            //Response
            $response = ["data" => 'Item Updated'];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }

    /**
     * DELETE A ITEM
     *
     * @param $criteria
     * @return mixed
     */
    public function delete($criteria, Request $request)
    {
        \DB::beginTransaction();
        try {
            //Get params
            $params = $this->getParamsRequest($request);

            //call Method delete
            $this->cart->deleteBy($criteria, $params);

            //Response
            $response = ["data" => ""];
            \DB::commit();//Commit to Data Base
        } catch (\Exception $e) {
          \Log::error($e->getMessage());
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response, $status ?? 200);
    }


}
