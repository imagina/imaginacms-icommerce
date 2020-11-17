<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;

class ManufacturerIndex extends Component
{
  
  private $view;
  private $params;
  private $defaultView;
  
  public function mount($params = [])
  {
    $this->defaultView = 'icommerce::frontend.livewire.manufacturer-index';
    $this->view = $params["view"] ?? $this->defaultView;
    $this->params = $params;
  }
  
  private function getManufacturerRepository(){
    return app('Modules\Icommerce\Repositories\ManufacturerRepository');
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
    
    $ttpl = 'icommerce.livewire.manufacturer-index';
    $this->view = (view()->exists($this->view) && $this->view != $this->defaultView) ? $this->view : (view()->exists($ttpl) ? $ttpl : $this->defaultView );
  
    $params = $this->makeParamsFunction();
    $manufacturers = $this->getManufacturerRepository()->getItemsBy(json_decode(json_encode($params)));
    
    return view($this->view, ['manufacturers' => $manufacturers, 'params' => $params]);
    
    
  }
}
