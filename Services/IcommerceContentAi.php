<?php


namespace Modules\Icommerce\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\AiService;
use Modules\Icommerce\Entities\Category;

class IcommerceContentAi
{
  public $aiService;

  function __construct()
  {
    $this->aiService = new AiService();
  }

  public function getProducts($quantity = 2)
  {
    //instance the prompt to generate the posts
    $prompt = "Información descriptiba de productos usados en un sitio WEB-ecommerce con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->aiService->getStandardPrompts(
      ["name", "description", "summary", "slug", "category_id", "price"],
      ["categories" => Category::get()]
    );
    //Call IA Service
    $response = $this->aiService->getContent($prompt, $quantity);
    //Return response
    return $response;
  }
}
