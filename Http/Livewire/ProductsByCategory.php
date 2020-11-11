<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Transformers\CategoryTransformer;
use Modules\Icommerce\Transformers\ProductTransformer;

class ProductsByCategory extends Component
{
  private $view;
  private $defaultView;
  private $criteria;
  private $field;
  private $params;
  
  public function mount($criteria, $field = "id", $params = [])
  {
    $this->criteria = $criteria;
    $this->defaultView = 'icommerce::frontend.livewire.products-by-category';
    $this->field = $field;
    $this->view = $params["view"] ?? $this->defaultView;
    $this->params = $params;
    
  }
  
  public function render()
  {

    $ttpl = 'icommerce.livewire.products-by-category';
  
    $this->view = (view()->exists($this->view) && $this->view != $this->defaultView) ? $this->view : (view()->exists($ttpl) ? $ttpl : $this->defaultView );
    
    $categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
    $params = json_decode(json_encode(["include" => ['files'], "filter" => ["field" => $this->field]]));
    $category = $categoryRepository->getItem($this->criteria, $params);
    
    $params = json_decode(json_encode([
      "include" => $this->params["include"] ?? ['category','categories','manufacturer'],
      "take" => $this->params["take"] ?? setting('icommmerce::product-per-page', null, 12),
      "page" => $this->params["page"] ?? 1,
      "filter" => $this->params["filter"] ?? [
        "category" => $category->id
        ],
      "order" => $this->params["order"] ?? null
    ]));
    
    $productRepository = app('Modules\Icommerce\Repositories\ProductRepository');
    $products = $productRepository->getItemsBy($params);
    
    return view($this->view, ['category' => new CategoryTransformer($category), 'products' => ProductTransformer::collection($products)]);
    
  }
}