<?php


namespace Modules\Icommerce\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\AiService;
use Modules\Icommerce\Entities\Category;

class IcommerceContentAi
{
  public $aiService;
  private $log = "Icommerce: Services|IcommerceContentAi|";

  private $maxAttempts;
  private $categoryQuantity = 3;
  private $productQuantity = 4;

  private $categoryRepository;
  private $productRepository;
  
  function __construct()
  {

    $this->aiService = new AiService();
    $this->maxAttempts = (int)setting("isite::n8nMaxAttempts", null, 3);
    $this->categoryRepository = app("Modules\Icommerce\Repositories\CategoryRepository");
    $this->productRepository = app("Modules\Icommerce\Repositories\ProductRepository");

  }

  public function getCategories($quantity = 2)
  {
    \Log::info($this->log . "getCategories|INIT");
    //instance the prompt to generate the categories
    $prompt = "Información descriptiva para categorias de productos usados en un sitio WEB-ecommerce con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->aiService->getStandardPrompts(
      ["title", "shortTitle", "description", "slug", "shortSlug","tags"]
    );
    //Call IA Service
    $response = $this->aiService->getContent($prompt, $quantity);
    \Log::info($this->log . "getCategories|END");
    //Return response
    return $response;
  }

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

    $newCategories = $this->getNewDataCategories();

    if(!is_null($newCategories)){
      
      //Delete Old Data
      $this->deleteOldData();

      //New Information
      $this->createCategories($newCategories);
      
      $newProducts = $this->getNewDataProducts();
      if(!is_null($newProducts)){
        $this->createProducts($newProducts);
      }
      
    }
    
  }

  /**
  * Get the New Data Categories
  */
  public function getNewDataCategories()
  {
    
    $newData = null;

    $attempts = 0;
    do {
      \Log::info($this->log."getNewData|Attempt:".($attempts+1)."/Max:".$this->maxAttempts);
      $newData = $this->getCategories($this->categoryQuantity);
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
   * Create Cate
   */
  public function createCategories($categories)
  {

    \Log::info($this->log."createCategories");


    foreach ($categories as $key => $category) {

      //\Log::info($this->log."createCategories|".json_encode($category));

      $category['es']['title'] = $category['es']['shortTitle'];
      $category['es']['slug'] = $category['es']['shortSlug'];
      $category['en']['title'] = $category['en']['shortTitle'];
      $category['en']['slug'] = $category['en']['shortSlug'];

      unset($category['es']['shortTitle']);
      unset($category['es']['shortSlug']);
      unset($category['en']['shortTitle']);
      unset($category['en']['shortSlug']);

      // Image Process
      if(isset($category['image']) && isset($category['image'][0])){
        $file = $this->aiService->saveImage($category['image'][0]);
        $category['medias_single']['mainimage'] = $file->id;
      }

      //Delete data from AI
      if(isset($category['tags'])) unset($category['tags']);
      if(isset($category['image'])) unset($category['image']);

      $result = $this->categoryRepository->create($category);
      
    }
   
  }

  /**
   * Delete old Categories and Products
   */
  public function deleteOldData()
  {

    $products = $this->productRepository->getItemsBy();
    if(count($products)>0){
      \Log::info($this->log."deleteOldData|Delete Old Products");
      foreach ($products as $key => $product) {
        $product->delete();
      }
    }

    $params = ["include" => []];
    $categories = $this->categoryRepository->getItemsBy(json_decode(json_encode($params)));
    if(count($categories)>0){
      \Log::info($this->log."deleteOldData|Delete Old Categories");
      foreach ($categories as $key => $category) {
        $category->delete();
      }
    }
    
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

      if(isset($product['es']['name']))
          \Log::info($this->log."createProducts|Name: ".$product['es']['name']);

      $result = $this->productRepository->create($product);

    }
   
  }


}
