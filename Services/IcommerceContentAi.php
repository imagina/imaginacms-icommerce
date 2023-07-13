<?php


namespace Modules\Icommerce\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\AiService;
use Modules\Icommerce\Entities\Category;

class IcommerceContentAi
{
  public $aiService;
  private $log = "Icommerce: Services|IcommerceContentAi|";

  function __construct()
  {
    $this->aiService = new AiService();
  }

  public function getCategories($quantity = 2)
  {
    \Log::info($this->log . "getCategories|INIT");
    //instance the prompt to generate the categories
    $prompt = "Información descriptiva para categorias de productos usados en un sitio WEB-ecommerce con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->aiService->getStandardPrompts(
      ["title", "description", "slug"]
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
      ["name", "description", "summary", "slug", "category_id", "price"],
      ["categories" => Category::get()]
    );
    //Call IA Service
    $response = $this->aiService->getContent($prompt, $quantity);
    \Log::info($this->log . "getProducts|END");
    //Return response
    return $response;
  }
}
