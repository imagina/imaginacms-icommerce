<?php

namespace Modules\Icommerce\Http\Livewire\Index\Filters;

use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CategoryRepository;

class Categories extends Component
{
  
  private $categoryBreadcrumb;
  
  public $categories;
  public $configs;
  public $manufacturer;
  public $category;
  
  public $extraParamsUrl;
  
  protected $listeners = ['updateExtraParams'];
  
  public function mount($categoryBreadcrumb, $manufacturer, $category)
  {
    
    
    $this->categoryBreadcrumb = $categoryBreadcrumb;
    $this->extraParamsUrl = "";
    
    $this->manufacturer = $manufacturer;
    $this->category = $category;
    
    $this->initConfigs();
  }
  
  
  /*
  * Init Configs to ProductList
  *
  */
  public function initConfigs(){
    
    $this->configs = config("asgard.icommerce.config.filters.categories");
    
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
    
    $tpl = 'icommerce::frontend.livewire.index.filters.categories.index';
    $ttpl = 'icommerce.livewire.filter-categories';
    
    $params = json_decode(json_encode([
      "include" => ['translations'],
      "take" => 0,
      "filter" => [
      ]
    ]));
    
    $this->categories = $this->getCategoryRepository()->getItemsBy($params);
    
    if (view()->exists($ttpl)) $tpl = $ttpl;
    
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

    }elseif (isset($this->category->id) && isset($this->configs["mode"])) {
      switch($this->configs["mode"]){
        case 'allFamilyOfTheSelectedNode':
          $ancestors = Category::ancestorsAndSelf($this->category->id);
          $rootCategory = $ancestors->whereNull('parent_id')->first();
          $this->categories = Category::descendantsAndSelf($rootCategory->id);
          break;
  
        case 'onlyLeftAndRightOfTheSelectedNode':
          $ancestors = Category::ancestorsOf($this->category->id);
          $descendants = $result = Category::descendantsAndSelf($this->category->id);
          $siblings = $this->category->getSiblings();
          $this->categories = $ancestors->merge($descendants)->merge($siblings);
          break;
      }
    
      
      
      
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