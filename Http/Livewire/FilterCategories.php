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

  public $extraParamsUrl;

  protected $listeners = ['updateExtraParams'];
  
  public function mount($categoryBreadcrumb)
  {

    
    $this->categoryBreadcrumb = $categoryBreadcrumb;
    $this->extraParamsUrl = "";
    
  }

  public function updateExtraParams($params){
    $this->extraParamsUrl = $params;
  }
  
  public function render()
  {
    
    $tpl = 'icommerce::frontend.livewire.filter-categories';
    $ttpl = 'icommerce.livewire.filter-categories';
  
    $params = (object)[
      "include" => ['translations'],
      "take" => 0,
      
    ];

    $this->categoryRepository = app('Modules\Icommerce\Repositories\CategoryRepository');
    $this->categories = $this->categoryRepository->getItemsBy($params);

    if (view()->exists($ttpl)) $tpl = $ttpl;
    
    return view($tpl,['categoryBreadcrumb' => $this->categoryBreadcrumb]);
  }
  
}