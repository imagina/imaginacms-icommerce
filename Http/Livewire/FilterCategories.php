<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Category;
use Modules\Icommerce\Repositories\CategoryRepository;

class FilterCategories extends Component
{
  
  private $categoryBreadcrumb;
  private $categoryRepository;
  
  public $categories;
  public $manufacturer;

  public $extraParamsUrl;

  protected $listeners = ['updateExtraParams'];
  
  public function mount($categoryBreadcrumb,$manufacturer)
  {

    
    $this->categoryBreadcrumb = $categoryBreadcrumb;
    $this->extraParamsUrl = "";

    $this->manufacturer = $manufacturer;
    
  }

  public function updateExtraParams($params){
    $this->extraParamsUrl = $params;
  }
  
  public function render()
  {
    
    $tpl = 'icommerce::frontend.livewire.filter-categories';
    $ttpl = 'icommerce.livewire.filter-categories';

    $params = json_decode(json_encode([
      "include" => ['translations'],
      "take" => 0,
      "filter" => [
        "manufacturers" => $this->manufacturer->id ?? null
      ]
    ]));

    $this->categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
    $this->categories = $this->categoryRepository->getItemsBy($params);

    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    return view($tpl,['categoryBreadcrumb' => $this->categoryBreadcrumb]);
  }
  
}