<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class CategoryList extends Component
{
  
  
  public $categories;
  public $params;
  public $layout;
  public $view;
  public $showDescription;
  public $columns;
  /**
   * Create a new component instance.
   *
   * @return void
   */
  public function __construct($params,$layout,$showDescription = false, $columns = ["col-12 col-md-6","col-12 col-md-6","col-12 col-md-5", "col-12 col-md-7"])
  {
    $this->params = $params;
    $this->layout = $layout;
    $this->view = "icommerce::frontend.components.category.category-list.layouts." . $layout.".index";
    $this->showDescription = $showDescription;
    $this->columns = $columns;
  
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
  
    if(isset($this->params["filter"]["ids"])){
      $ids = $this->params["filter"]["ids"];
      $this->categories = $this->categories->sortBy(function($model) use ($ids) {
        return array_search($model->getKey(), $ids);
      });
    }
    
    return view($this->view);
  }
}