<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Modules\Icommerce\Transformers\CategoryTransformer;

class CategoryIndex extends Component
{
  
  private $view;
  private $params;
  private $defaultView;
  
  public function mount($params = [])
  {
    $this->defaultView = 'icommerce::frontend.livewire.category-index';
    $this->view = $params["view"] ?? $this->defaultView;
    $this->params = $params;
  }
  
  public function render()
  {
    
    $ttpl = 'icommerce.livewire.category-index';
    $this->view = (view()->exists($this->view) && $this->view != $this->defaultView) ? $this->view : (view()->exists($ttpl) ? $ttpl : $this->defaultView );
    
    $params = json_decode(json_encode([
      "include" => $this->params["include"] ?? [],
      "take" => $this->params["take"] ?? 12,
      "page" => $this->params["page"] ?? 1,
      "filter" => $this->params["filter"] ?? [],
      "order" => $this->params["order"] ?? null
    ]));
    
    $this->categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
    $categories = $this->categoryRepository->getItemsBy($params);
    
    return view($this->view, ['categories' => CategoryTransformer::collection($categories)]);
    
    
  }
}
