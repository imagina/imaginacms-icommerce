<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Http\Requests\CreateProductRequest;
use Modules\Icommerce\Http\Requests\ProductImportRequest;
// Base Api
use Modules\Icommerce\Http\Requests\UpdateProductRequest;
// Transformers
use Modules\Icommerce\Imports\IcommerceImport;
// Entities
use Modules\Icommerce\Repositories\ProductRepository;
// Repositories
use Modules\Icommerce\Transformers\ProductTransformer;
//External libraries
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;

class ProductApiController extends BaseApiController
{
    private $product;

    private $category;

    private $manufacturer;

    private $setting;

    public function __construct(
        ProductRepository $product
    ) {
        $this->product = $product;
    }

    /**
     * Get List Products
     */
    public function index(Request $request): Response
    {
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $products = $this->product->getItemsBy($params);

            //Response
            $response = ['data' => ProductTransformer::collection($products)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($products)] : false;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
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
            $product = $this->product->getItem($criteria, $params);

            //Break if no found item
            if (! $product) {
                throw new \Exception('Item not found', 404);
            }

            //Response
            $response = ['data' => new ProductTransformer($product)];

            //If request pagination add meta-page
            $params->page ? $response['meta'] = ['page' => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = [
                'errors' => $e->getMessage(),
            ];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
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
            $data = $request->input('attributes') ?? []; //Get data

            //Validate Request
            $this->validateRequestApi(new CreateProductRequest($data));

            //Create item
            $product = $this->product->create($data);

            //Response
            $response = ['data' => new ProductTransformer($product)];
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
     * UPDATE ITEM
     *
     * @return mixed
     */
    public function update($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            //Get data
            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new UpdateProductRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $this->product->updateBy($criteria, $data, $params);

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
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
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

            //Request to Repository
            $this->product->deleteBy($criteria, $params);

            \DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    public function rating($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
            $this->setting = app("Modules\Setting\Contracts\Setting");

            //Get data
            $data = $request->input('attributes') ?? []; //Get data

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $product = $this->product->getItem($criteria, $params);

            $oldRating = $product->sumRating();

            //Break if no found item
            if (! $product) {
                throw new \Exception('Item not found', 500);
            }

            $rating = \willvincent\Rateable\Rating::where('user_id', \Auth::id())
                ->where('rateable_id', $criteria)
                ->where('rateable_type', \Modules\Icommerce\Entities\Product::class)
                ->first();

            if ($rating) {
                throw new \Exception('Ya has calificado este producto.', 401);
            }

            $rating = new \willvincent\Rateable\Rating;
            $rating->rating = $data['rating'];
            $rating->user_id = \Auth::id();

            $product->ratings()->save($rating);
            $product->update(['sum_rating' => $oldRating + $data['rating']]);

            $checkbox = $this->setting->get('iredeems::points-per-rating-product-checkbox');
            if ($checkbox) {
                $points = $this->setting->get('iredeems::points-per-rating-product');

                //Points by rating product
                iredeems_StorePointUser([
                    'user_id' => \Auth::id(),
                    'pointable_id' => $criteria,
                    'pointable_type' => 'product',
                    'description' => 'Puntos por calificar un producto',
                    'points' => $points,
                ]);
            }//Checkbox

            //Response
            $response = ['data' => 'Item Updated', 'store' => 'asd'];
            \DB::commit(); //Commit to DataBase
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback(); //Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }

    public function importProducts(Request $request)
    {
        $this->category = app("Modules\Icommerce\Repositories\CategoryRepository");
        $this->manufacturer = app("Modules\Icommerce\Repositories\ManufacturerRepository");
        $msg = '';
        try {
            $data = $request->all();
            //Validate Request
            $this->validateRequestApi(new ProductImportRequest($data));
            $user = \Auth::guard('api')->user() ?? \Auth::user();
            $data = ['folderpaht' => $request->folderpaht ?? '', 'user_id' => $user->id, 'Locale' => \LaravelLocalization::setLocale() ?: \App::getLocale()];
            $data_excel = Excel::import(new IcommerceImport($this->product, $this->category, $this->manufacturer, $data), $request->file);
            $msg = trans('icommerce::products.bulkload.success migrate from product');
            //Response
            $response = ['data' => $msg];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ['errors' => $e->getMessage()];
        }

        return response()->json($response ?? ['data' => 'Request successful'], $status ?? 200);
    }
}
