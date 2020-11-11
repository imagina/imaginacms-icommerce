<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Modules\Icommerce\Transformers\ProductTransformer;

class ProductIndex extends Component
{
  
  private $view;
  private $params;
  private $defaultView;
  
  public function mount($params = [])
  {
    
    $this->defaultView = 'icommerce::frontend.livewire.product-index';
    $this->view = $params["view"] ?? $this->defaultView;
    $this->params = $params;
   
  }
  
  public function render()
  {
  
    $ttpl = 'icommerce.livewire.products-index';
    $this->view = (view()->exists($this->view) && $this->view != $this->defaultView) ? $this->view : (view()->exists($ttpl) ? $ttpl : $this->defaultView );
    
    $params = json_decode(json_encode([
      "include" => $this->params["include"] ?? ['category','categories','manufacturer'],
      "take" => $this->params["take"] ?? setting('icommmerce::product-per-page', null, 12),
      "page" => $this->params["page"] ?? 1,
      "filter" => $this->params["filter"] ?? [],
      "order" => $this->params["order"] ?? null
    ]));
    
    $this->productRepository = app('Modules\Icommerce\Repositories\ProductRepository');
    $products = $this->productRepository->getItemsBy($params);

    return view($this->view, ['products' => $products]);
    
    
  }
}
