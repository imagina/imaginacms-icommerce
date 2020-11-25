<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Modules\Icommerce\Transformers\ProductTransformer;

class ProductIndex extends Component
{
  private $params;
  private $defaultView;
  public $title;
  public $subTitle;
  public $name;
  public function mount($params = [],$title = null, $subTitle = null, $name = "")
  {
    $this->title = $title;
    $this->subTitle = $subTitle;
    $this->name = $name;
    $this->defaultView = 'icommerce::frontend.livewire.product-index';
    $this->params = $params;
   
  }
  
  public function render()
  {
  
    $params = json_decode(json_encode([
      "include" => $this->params["include"] ?? ['category','categories','manufacturer'],
      "take" => $this->params["take"] ?? setting('icommmerce::product-per-page', null, 12),
      "page" => $this->params["page"] ?? 1,
      "filter" => $this->params["filter"] ?? [],
      "order" => $this->params["order"] ?? null
    ]));
    
    $products = $this->productRepository()->getItemsBy($params);

    return view($this->defaultView, ['products' => $products]);
    
    
  }
  
  /**
   * @return productRepository
   */
  private function productRepository()
  {
    return app('Modules\Icommerce\Repositories\ProductRepository');
  }
}
