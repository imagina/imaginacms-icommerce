<?php


namespace Modules\Icommerce\Services;

use Illuminate\Http\Request;
use Modules\Isite\Services\IAService;
use Modules\Icommerce\Entities\Category;

class IcommerceContentIA
{
  public $iaService;

  function __construct()
  {
    $this->iaService = new IAService();
  }

  public function getProducts($quantity = 2)
  {
    //instance the prompt to generate the posts
    $prompt = "Información descriptiba de productos usados en un sitio WEB-ecommerce con los siguientes atributos ";
    //Instance attributes
    $prompt .= $this->iaService->getStandardPrompts(
      ["name", "description", "summary", "slug", "category_id", "price"],
      ["categories" => Category::get()]
    );
    //Call IA Service
    $response = $this->iaService->getContent($prompt, $quantity);
    //Return response
    return $response;
  }
}
