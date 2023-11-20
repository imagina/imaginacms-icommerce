<?php


namespace Modules\Icommerce\Services;

use Modules\Isite\Services\AiService;
use Modules\Icommerce\Entities\Category;

class IcommerceProductsContentAi
{
  public $aiService;
  private $log = "Icommerce: Services|IcommerceProductsContentAi|";

  private $maxAttempts;
  private $productQuantity = 4;

  private $productRepository;
  
  function __construct()
  {
    $this->aiService = new AiService();
    $this->maxAttempts = (int)setting("isite::n8nMaxAttempts", null, 3);
    $this->productRepository = app("Modules\Icommerce\Repositories\ProductRepository");
  }

  /**
   * API REQUEST WITH PROMPT
   */
  public function getProducts($quantity = 2)
  {
    \Log::info($this->log . "getProducts|INIT");
    //instance the prompt to generate the products
    $prompt = "Información descriptiva de productos usados en un sitio WEB-ecommerce con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->aiService->getStandardPrompts(
      ["name", "description", "summary", "slug", "category_id", "price","tags"],
      ["categories" => Category::get()]
    );
    //Call IA Service
    $response = $this->aiService->getContent($prompt, $quantity);
    \Log::info($this->log . "getProducts|END");
    //Return response
    return $response;
  }

  /**
  * Principal
  */
  public function startProcesses()
  {

    \Log::info($this->log."startProcesses");

    $newProducts = $this->getNewDataProducts();

    if(!is_null($newProducts)){
      $this->createProducts($newProducts);
    }
    
  }

  /**
  * Get the New Data Products
  */
  public function getNewDataProducts()
  {

    $newData = null;

    $attempts = 0;
    do {
      \Log::info($this->log."getNewData|Attempt:".($attempts+1)."/Max:".$this->maxAttempts);
      $newData = $this->getProducts($this->productQuantity);
      if(is_null($newData)){
        $attempts++;
      }else{
        if(isset($newData[0]['es']) && isset($newData[0]['en']))
          break;
        else
          $attempts++;
      }
    }while($attempts < $this->maxAttempts);

    return $newData;

  }
  
  /**
   * Create Products
   */
  public function createProducts($products)
  {

    \Log::info($this->log."createProducts");

    foreach ($products as $key => $product) {

      // Image Process
      if(isset($product['image']) && isset($product['image'][0])){
        $file = $this->aiService->saveImage($product['image'][0]);
        $product['medias_single']['mainimage'] = $file->id;
      }

      //Delete data from AI
      if(isset($product['tags'])) unset($product['tags']);
      if(isset($product['image'])) unset($product['image']);

      $product['added_by_id'] = 1;
      $product['status'] = 1; //Published
      $product['parent_id'] = NULL;
      $product['quantity'] = 9999;
      $product['stock_status'] = 1;

      if(isset($product['category_id'])) \Log::info($this->log."createProducts|CategoryId: ".$product['category_id']);
      //if(isset($product['es']['name'])) \Log::info($this->log."createProducts|Name: ".$product['es']['name']);
  
      try{
        $result = $this->productRepository->create($product);
      } catch (\Exception $e) {
        \Log::error($this->log."Error|Message: ".$e->getMessage());
      }
      

    }
   
  }


}
