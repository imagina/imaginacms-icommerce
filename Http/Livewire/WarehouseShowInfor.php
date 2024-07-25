<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;


class WarehouseShowInfor extends Component
{
  public $layout;
  public $view;
  public $log;
  public $readyToLoad = false;

  public $warehouseSession;
  public $warehouseVar;

  /**
   * MOUNT
   */
  public function mount(
    $layout = 'warehouse-show-infor-layout-1', 
    $warehouseVar  
  ){
      $this->log = "Icommerce::Livewire|WarehouseShowInfor|";
     
      $this->layout = $layout;
      $this->view = "icommerce::frontend.livewire.warehouse-show-infor.layouts.$this->layout.index";

      $this->warehouseSession = session("warehouse");
      //\Log::info($this->log."WarehouseSession: ".$this->warehouseSession);
      $this->warehouseVar = $warehouseVar;
     
  }

  /**
   * WIRE INIT
   */
  public function loadWarehouseShowInfor()
  {
      $this->readyToLoad = true;
  }

  /**
   *  Proccess to get Information | Case: Active Cache
   */
  public function getInfor()
  {
    
    \Log::info($this->log.'getInfor');

    if(!is_null($this->warehouseSession)){
      return $this->warehouseSession->title;
    }else{
      \Log::info($this->log.'getInfor|warehouse|Session Warehouse NO EXISTE');
      return "...";
    }

  }


  //|--------------------------------------------------------------------------
  //| Render
  //|--------------------------------------------------------------------------
  /**
   * @return mixed
   */
  public function render()
  { 

    return view($this->view,[
      'infor' => $this->readyToLoad ? $this->getInfor() : "..."
    ]);

  }

}
