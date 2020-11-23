<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CategoryRepository;

class FilterCategories extends Component
{
  
  private $categoryBreadcrumb;
  
  public $categories;
  public $manufacturer;
  
  public $extraParamsUrl;
  
  protected $listeners = ['updateExtraParams'];
  
  public function mount($categoryBreadcrumb, $manufacturer)
  {
    
    
    $this->categoryBreadcrumb = $categoryBreadcrumb;
    $this->extraParamsUrl = "";
    
    $this->manufacturer = $manufacturer;
    
  }
  
  public function updateExtraParams($params)
  {
    $this->extraParamsUrl = $params;
  }
  
  private function getCategoryRepository()
  {
    return app('Modules\Icommerce\Repositories\CategoryRepository');
  }
  
  public function render()
  {
    
    $tpl = 'icommerce::frontend.livewire.filter-categories';
    
    $params = json_decode(json_encode([
      "include" => ['translations'],
      "take" => 0,
      "filter" => [
      ]
    ]));
    
    $this->categories = $this->getCategoryRepository()->getItemsBy($params);
    
    if (isset($this->manufacturer->id)) {
      $params = json_decode(json_encode([
        "include" => ['translations'],
        "take" => 0,
        "filter" => [
          "manufacturers" => $this->manufacturer->id ?? null
        ]
      ]));
      
      $categoriesOfManufacturer = $this->getCategoryRepository()->getItemsBy($params);
      $parents = [];
      
      foreach ($categoriesOfManufacturer as $categoryManufacturer) {
        $this->getParents($categoryManufacturer, $parents);
      }
      
      $this->categories = collect($parents)->merge($categoriesOfManufacturer)->keyBy("id");

    }
    
    return view($tpl, ['categoryBreadcrumb' => $this->categoryBreadcrumb]);
  }
  
  private function getParents($categoryManufacturer, &$parents = [])
  {
    foreach ($this->categories as $category) {
      if ($categoryManufacturer->parent_id == $category->id) {
        array_push($parents, $category);
        $this->getParents($category, $parents);
      }
    }
  }
  
}