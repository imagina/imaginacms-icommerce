<?php

namespace Modules\Icommerce\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Icrud\Controllers\BaseCrudController;
//Model
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Repositories\ProductRepository;

class ProductApiController extends BaseCrudController
{
  public $model;
  public $modelRepository;

  public function __construct(Product $model, ProductRepository $modelRepository)
  {
    $this->model = $model;
    $this->modelRepository = $modelRepository;
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
    //Response
    return $fileService->store($uploadedFile, 0, 'publicmedia');
  }
}
