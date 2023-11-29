<?php

namespace Modules\Icommerce\Http\Controllers\Api;

// Requests & Response
use Modules\Icommerce\Http\Requests\CreateProductRequest;
use Modules\Icommerce\Http\Requests\ProductRequest;
use Modules\Icommerce\Http\Requests\ProductImportRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Icommerce\Http\Requests\UpdateProductRequest;
use Modules\Icommerce\Imports\IcommerceImport;


// Base Api
use Modules\Ihelpers\Http\Controllers\Api\BaseApiController;
use Exception;

// Transformers
use Modules\Icommerce\Transformers\ProductTransformer;

// Entities
use Modules\Icommerce\Entities\Product;

// Repositories
use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Icommerce\Repositories\CategoryRepository;
use Modules\Icommerce\Repositories\ManufacturerRepository;

//External libraries
use Maatwebsite\Excel\Facades\Excel;
use Modules\Setting\Contracts\Setting;


class ProductApiController extends BaseApiController
{
    private $product;
    private $category;
    private $manufacturer;
    private $setting;

    public function __construct(
        ProductRepository $product
    )
    {
        $this->product = $product;
    }

    /**
     * Get List Products
     * @return Response
     */
    public function index(Request $request)
    {
     
        try {
            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);
            //Request to Repository
            $products = $this->product->getItemsBy($params);

            //Response
            $response = ['data' => ProductTransformer::collection($products)];
      
            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($products)] : false;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
            $product = $this->product->getItem($criteria, $params);

            //Break if no found item
            if (!$product) throw new \Exception('Item not found', 404);

            //Response
            $response = ["data" => new ProductTransformer($product)];
   
            //If request pagination add meta-page
            $params->page ? $response["meta"] = ["page" => $this->pageTransformer($dataEntity)] : false;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $status = $this->getStatusError($e->getCode());
            $response = [
                "errors" => $e->getMessage()
            ];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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
            $data = $request->input('attributes') ?? [];//Get data

            //Validate Request
            $this->validateRequestApi(new CreateProductRequest($data));

            //Create item
            $product = $this->product->create($data);

            //Response
            $response = ["data" => new ProductTransformer($product)];
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
            $data = $request->input('attributes') ?? [];

            $this->validateRequestApi(new UpdateProductRequest($data));

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $this->product->updateBy($criteria, $data, $params);

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
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
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


            //Request to Repository
            $this->product->deleteBy($criteria, $params);

            \DB::commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback();
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    public function rating($criteria, Request $request)
    {
        \DB::beginTransaction(); //DB Transaction
        try {
          $this->setting = app("Modules\Setting\Contracts\Setting");
          
            //Get data
            $data = $request->input('attributes') ?? [];//Get data

            //Get Parameters from URL.
            $params = $this->getParamsRequest($request);

            //Request to Repository
            $product = $this->product->getItem($criteria, $params);

            $oldRating = $product->sumRating();

            //Break if no found item
            if (!$product) throw new \Exception('Item not found', 500);

            $rating = \willvincent\Rateable\Rating::where('user_id', \Auth::id())
                ->where('rateable_id', $criteria)
                ->where('rateable_type', \Modules\Icommerce\Entities\Product::class)
                ->first();

            if ($rating) throw new \Exception('Ya has calificado este producto.', 401);

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
                    "user_id" => \Auth::id(),
                    "pointable_id" => $criteria,
                    "pointable_type" => "product",
                    "description" => "Puntos por calificar un producto",
                    "points" => $points
                ]);

            }//Checkbox

            //Response
            $response = ["data" => 'Item Updated', 'store' => 'asd'];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \DB::rollback();//Rollback to Data Base
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        //Return response
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    public function importProducts(Request $request)
    {
      $this->category = app("Modules\Icommerce\Repositories\CategoryRepository");
      $this->manufacturer = app("Modules\Icommerce\Repositories\ManufacturerRepository");
        $msg = "";
        try {
            $data = $request->all();
            //Validate Request
            $this->validateRequestApi(new ProductImportRequest($data));
            $user = \Auth::guard('api')->user() ?? \Auth::user();
            $data = ['folderpaht' => $request->folderpaht ?? "", 'user_id' => $user->id, 'Locale' => \LaravelLocalization::setLocale() ?: \App::getLocale()];
            $data_excel = Excel::import(new IcommerceImport($this->product, $this->category, $this->manufacturer, $data), $request->file);
            $msg = trans('icommerce::products.bulkload.success migrate from product');
            //Response
            $response = ["data" => $msg];
        } catch (\Exception $e) {
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }
        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);

    }

    public function syncProducts($criteria, Request $request)
    {
        $msg = "";
        $category = app("Modules\Icommerce\Http\Controllers\Api\CategoryApiController");
        \DB::beginTransaction(); //DB Transaction
        try {
            $data = $request->input('attributes') ?? [];//Get data

            // Get Product by SKU with settings fromAdmin
            $product = $this->show($criteria, new Request([
              "setting" => ["fromAdmin" => true],
              "filter" => ["field" => "sku"]
            ]));

            $mainImage = $data["medias_single"]["mainimage"] ?? "";
            $mediasMulti = $data["medias_multi"]["gallery"] ?? [];
            $data["medias_single"] = [];
            $data["medias_multi"] = [];

            // Check if exist product
            if(isset($product->original["data"]) && $product->original["data"]) {
                $product = $product->original["data"];
                $data["id"] = $product['id'];
                unset($data["es"]["slug"]);
                $requestData = ["attributes" => $data];
                // Create new Request
                $request = new Request($requestData);
                //Update the product
                $msg = $this->update($product['id'], $request);
            } else {
                $requestData = ["attributes" => $data];
                // Create new Request
                $request = new Request($requestData);
                //Create the product
                $msg = $this->create($request);
            }

            // Check if there is a main image URL (mainImage)
            if (isset($mainImage) && $mainImage && !isset($msg->original["errors"])) {
                $data["medias_single"]["mainimage"] = $this->getFileId($mainImage)->id;
            }

            // Check if there are multiple image URLs (mediasMulti)
            if (isset($mediasMulti) && $mediasMulti && !isset($msg->original["errors"])) {
                $mediasIds = [];

                // Iterate over the multiple image URLs
                foreach ($mediasMulti as $media) {
                    $mediasIds[] = $this->getFileId($media)->id;
                }

                // Assign the IDs of the multiple images to the medias_multi array
                $data["medias_multi"]["gallery"]["files"] = $mediasIds;

                // Convert the IDs into a comma-separated string and assign it to 'orders'
                $data["medias_multi"]["gallery"]["orders"] = implode(",", $mediasIds);
            }

            // Check if there are images (medias_single or medias_multi)
            if (!isset($msg->original["errors"]) &&
                ((isset($data["medias_single"]) && isset($data["medias_single"]["mainimage"])) ||
                (isset($data["medias_multi"]) && isset($data["medias_multi"]["gallery"])))) {
                if (!isset($data["id"])) {
                    // Get the product by SKU with the fromAdmin configuration
                    $product = $this->show($criteria, new Request([
                        "setting" => ["fromAdmin" => true],
                        "filter" => ["field" => "sku"]
                    ]));

                    $data["id"] = $product->original["data"]["id"];
                }

                // Prepare the request data
                $requestData = ["attributes" => $data];

                // Update the product
                $msg = $this->update($data["id"], new Request($requestData));
            }

            //Response
            $response = ["data" => $msg];
            \DB::commit();//Commit to DataBase
        } catch (\Exception $e) {
            \DB::rollback();//Rollback to Data Base
            \Log::error($e->getMessage(), $e->getFile(), $e->getLine());
            // TODO: It is necessary to create a service in the media to create a rollback, because when the insertion fails, the images are saved to the disk (This is an improvement because when this service throws an error, the media tries to associate the image if it is uploaded again)
            $status = $this->getStatusError($e->getCode());
            $response = ["errors" => $e->getMessage()];
        }

        return response()->json($response ?? ["data" => "Request successful"], $status ?? 200);
    }

    private function getFileId($url)
    {
        //Instance file service
        $fileService = app("Modules\Media\Services\FileService");
        //Get base64 file
        $uploadedFile = getUploadedFileFromUrl($url);
        //Create file
        $response = $fileService->store($uploadedFile, 0, 'publicmedia');
        //Response
        return $response;
    }
}
