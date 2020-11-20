<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Modules\Icommerce\Entities\Category;

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
  
  private function getCategoryRepository(){
    return app('Modules\Icommerce\Repositories\CategoryRepository');
  }
  
  private function makeParamsFunction(){
    
    return [
      "include" => $this->params["include"] ?? [],
      "take" => $this->params["take"] ?? 12,
      "page" => $this->params["page"] ?? 1,
      "filter" => $this->params["filter"] ?? [],
      "order" => $this->params["order"] ?? null
    ];
  }
  
  public function render()
  {
   
    $ttpl = 'icommerce.livewire.category-index';
    $this->view = (view()->exists($this->view) && $this->view != $this->defaultView) ? $this->view : (view()->exists($ttpl) ? $ttpl : $this->defaultView );
   
    $params = $this->makeParamsFunction();
    $categories = $this->getCategoryRepository()->getItemsBy(json_decode(json_encode($params)));
   
    if(isset($this->params["toTree"])){

      $categories = $categories->toTree();
      
    }
    return view($this->view, ['categories' => $categories, 'params' => $params]);
    
    
  }
  

}
