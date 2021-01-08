<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class CategoryList extends Component
{
  
  
  public $categories;
  public $params;
  public $layout;
  public $view;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($params,$layout)
  {
    $this->params = $params;
    $this->layout = $layout;
    $this->view = "icommerce::frontend.components.category.category-list.layouts." . $layout.".index";
  
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
  /**
   * Get the view / contents that represent the component.
   *
   * @return \Illuminate\Contracts\View\View|string
   */
  public function render()
  {
    $params = $this->makeParamsFunction();
    $this->categories = $this->getCategoryRepository()->getItemsBy(json_decode(json_encode($params)));

    
    return view($this->view);
  }
}