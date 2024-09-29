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

  public $showComponent = false;
  public $title = "";

  //Clases del Blade
  public $textClass;
  public $addressClass;
  public $user;
  public $warehouseLocatorId;
  public $activeTooltip;

  //Base
  public $warehouse;
  public $shippingAddress;
  public $shippingMethods;

 
  /**
  * LISTENERS
  */
  protected $listeners = [
    'warehouseBladeIsReady' => 'checkComponentReady'
  ];

  /**
   * MOUNT
   */
  public function mount(
    $warehouseVar,
    $layout = 'warehouse-show-infor-layout-1',
    $textClass = '',
    $addressClass = '',
    $warehouseLocatorId = null
  ){
      $this->log = "Icommerce::Livewire|WarehouseShowInfor|";
      //\Log::info($this->log."MOUNT");
     
      $this->layout = $layout;
      $this->view = "icommerce::frontend.livewire.warehouse-show-infor.layouts.$this->layout.index";

      //Vars Blade Component
      $this->textClass = $textClass;
      $this->addressClass = $addressClass;
      //$this->user = \Auth::user() ?? null;
      $this->$warehouseLocatorId = $warehouseLocatorId;

      //Shipping Method Base
      $this->shippingMethods = config('asgard.icommerce.config.warehouseShippingMethods');

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

      /**
      * Con el cache activo:
      * Cuando cambiaba de Warehouse, en el Mount estaba bien la sesion, pero aqui no, ejecutaba primero esto que el Mount
      * por eso se vuelve a setear la variable
      */
      //$this->warehouseSession = session("warehouse");

      \Log::info($this->log.'getInfor|warehouse: '.$this->warehouseSession->title);
      return $this->warehouseSession->title;
    }else{
      \Log::info($this->log.'getInfor|warehouse|Session Warehouse NO EXISTE');
      return "...";
    }

  }

  /*
  * LISTENER
  * ready from Blade Component
  */
  public function checkComponentReady()
  {
    \Log::info($this->log."Listener|checkComponentReady|warehouseBladeIsReady: YES");

    $this->init();

    //Set Infor Variable
    if(!is_null($this->warehouse))
    {
      \Log::info($this->log.'Listener|checkComponentReady|warehouse: '.$this->warehouse->title);

      $space = "";
      if(isset($this->user) && !empty($this->user->first_name)) $space = " ";
      
      $this->title = "<a class='address cursor-pointer {$this->addressClass}' data-toggle='modal' data-target='#modalWarehouseLocator'> ".
                trans('icommerce::warehouses.messages.hello').$space.($this->user ? $this->user->first_name : "") . ", " . trans('icommerce::warehouses.messages.buying for') . " " .
                $this->warehouse->title .
            "</a>";
      
    }
    if(isset($this->user->id) && !empty($this->shippingAddress)){
        $this->title = "<span class='{$this->textClass}'>".
            trans("icommerce::warehouses.messages.hello").$space.$this->user->first_name. ",".
            ($this->text ?? trans('icommerce::warehouses.messages.your address is')) .
            "</span>" .
            "<a class='address cursor-pointer {$this->addressClass}' data-toggle='modal' data-target='#modalWarehouseLocator'>" .
            "<u> ". $this->shippingAddress->address_1 ."</u>" .
            "</a>";
    }
     
    
    //Sleep
    sleep(1);

    // EMIT TO Warehouse Locator
    $this->emit("warehouseShowInforIsReady");

    // Show Component
    $this->showComponent = true;
   
  }

  /**
  * @return addressRepository
  */
  public function addressRepository()
  {
    return app('Modules\Iprofile\Repositories\AddressRepository');
  }

  /**
   * @return warehouseRepository
   */
  public function warehouseRepository()
  {
    return app('Modules\Icommerce\Repositories\WarehouseRepository');
  }

  /**
   * @return warehouseService
   */
  public function warehouseService()
  {
    return app('Modules\Icommerce\Services\WarehouseService');
  }


  /**
  *  Set Vars with Sessions
  */
  public function setInitVars()
  {
    \Log::info($this->log . 'setInitVars');

    $this->user = \Auth::user() ?? null;

    //Clean Values | Only Testing
    //$this->warehouseService()->cleanSessionVars();

    //Shipping Method Name DEFAULT
    if (is_null(request()->session()->get("shippingMethodName")))
      request()->session()->put('shippingMethodName', $this->shippingMethods['pickup']);

    $warehouse = request()->session()->get('warehouse');
    if (!is_null($warehouse)) {
      $warehouse = json_decode($warehouse);
      if (isset($warehouse->id)) {
        $this->warehouse = $this->warehouseRepository()->getItem($warehouse->id);
      }

    }
  
    $shippingAddress = request()->session()->get('shippingAddress');
    if (!is_null($shippingAddress)) {
      $shippingAddress = json_decode($shippingAddress);
      if (isset($shippingAddress->id)) {
        $this->shippingAddress = $this->addressRepository()->getItem($shippingAddress->id);
      }
    }
    
    $showTooltip = request()->session()->get("showTooltip");
    $this->activeTooltip = $showTooltip ?? true;

    $warehouseAlert = request()->session()->get('warehouseAlert');
    if(!is_null($warehouseAlert) && $warehouseAlert)
      $this->dispatchBrowserEvent('show-modal-alert-warehouse-coverage');

  }

  /**
   * Set default Warehouse
   */
  public function setDefaultWarehouse()
  {
    \Log::info($this->log . 'setDefaultWarehouse');

    $params['filter']['field'] = "default";
    $default = $this->warehouseRepository()->getItem(true, json_decode(json_encode($params)));

    if (!is_null($default)) {
      $this->warehouse = $default;
      request()->session()->put('warehouse', json_encode($this->warehouse));
      //session(['warehouse' => $this->warehouse]);
    }
  }

  /**
   *  Get user shipping address default
   */
  public function getAndSetShippingAddress()
  {
    \Log::info($this->log . 'getAndSetShippingAddress');

    $shippingAddress = $this->user->addresses()
    ->where(["type" =>"shipping","default" => 1])->first();

    if (!is_null($shippingAddress)) {
      //Get Default
      $this->shippingAddress = $shippingAddress;
      //Save in Session Shipping Address
      //session(['shippingAddress' => $this->shippingAddress]);
      request()->session()->put('shippingAddress', json_encode($this->shippingAddress));
      request()->session()->put('shippingMethodName', $this->shippingMethods['delivery']);

    } else {
      \Log::info($this->log . 'getAndsetShippingAddress|User has no address by default');
      request()->session()->put('shippingAddress', null);
    }
    
  }

  /**
   *  INIT PROCESS
   */
  public function init()
  {
    \Log::info($this->log . 'Init');

    //Set Livewire Variables with Session Variables
    $this->setInitVars();

    //$showTooltipSession = request()->session()->get("showTooltip");
    
    //Case: User NOT LOGGED AND Null Warehouse to not repeat after process
    if (is_null($this->user) && is_null($this->warehouse)) {
      \Log::info($this->log . 'User NOT LOGGED');
      //Assign Default Warehouse
      $this->setDefaultWarehouse();
    } else {

      //Case: User LOGGED
      if (!is_null($this->user)) {
        \Log::info($this->log . 'User LOGGED');
  
        $shippingAddressChecked = request()->session()->get("shippingAddressChecked") ?? null;
        //Check Shipping Address NULL and Process to Shipping Address with Warehouse
        if (is_null($this->shippingAddress) && is_null($shippingAddressChecked)) {

          //Get and Set Shipping Address default from the User
          $this->getAndSetShippingAddress();

          //User doesn't have Shipping Address
          if (is_null($this->shippingAddress)) {

            //Assign Default Warehouse
            $this->setDefaultWarehouse();

            //if(is_null($showTooltipSession)) $this->activeTooltip = true;
  
            request()->session()->put('shippingAddressChecked', true);

          } else {
            \Log::info($this->log . 'User has a Shipping Address');
            //Get warehouse to the address
            $warehouseToAddress = $this->shippingAddress->warehouse;

            //Proccess to get a Warehouse to the Address
            $warehouseProcess = $this->warehouseService()->getWarehouseToAddress($this->shippingAddress);

            //The address have a Warehouse and the Warehouse is active
            //WarehouseProcess(From calculations) must be the same that WarehouseToAddress
            //Nearby indica que el warehouse que se obtiene de WarehouseProcess, es el warehouse mas cercano (Caso que la direccion no tenga cobertura)
            if (!is_null($warehouseToAddress) && $warehouseToAddress->status==1 && $warehouseToAddress->id==$warehouseProcess['warehouse']->id && $warehouseProcess['nearby']==false) {
              \Log::info($this->log . 'Shipping Address has a warehouse');
              $warehouse = $warehouseToAddress;
            } else {
              //El warehouse de la direccion no cumple con los requisitos, por lo tanto toca asignar el de los calculos.
              \Log::info($this->log . 'Set Warehouse to address with Calculations');
              
              //Get Warehouse Data
              $warehouse = $warehouseProcess['warehouse'];

              //Save Warehouse for this Address
              $this->shippingAddress->warehouse_id = $warehouse->id;
              $this->shippingAddress->save();

              //Verifying that it was a nearby warehouse to show de Modal wiht message in front
              if (isset($warehouseProcess['nearby']) && $warehouseProcess['nearby']==true) {

                request()->session()->put('warehouse', json_encode($warehouse));

                //Set shipping method to Pickup
                session(["shippingMethodName" => $this->shippingMethods['pickup']]);

                //Show Sweet Alert in frontend
                request()->session()->put('warehouseAlert', true);

                //Para que en el layout no muestre la direccion del Usuario sino la del Warehouse
                session(['shippingAddress' => null]);
                //No entre a la validacion donde revisa las direcciones del usuario y asigna como seleccionada | Warehouse Component Blade
                session(['shippingAddressChecked' => true]);

                //Reload Page
                return redirect(request()->header('Referer'));
              }

            }

            //Solo si existe el warehouse (Recordar que en el caso de Nearby recarga)
            if (!is_null($warehouse)) {
              //Set Sessions
              $this->warehouse = $warehouse;
              //session(['warehouse' => $warehouse]);
              request()->session()->put('warehouse', json_encode($this->warehouse));
            }
          }
        }

      }else{
        \Log::info($this->log . 'User NOT LOGGED | Case 2');
        //User Not Logged but at one point the shippingAddress session variable was created
        if(!is_null(request()->session()->get("shippingAddress"))) {
          request()->session()->put('shippingAddress', null);
        }

      }
    }

    
    //Show Tooltip
    //if (is_null($this->shippingAddress) && is_null($showTooltipSession)) $this->activeTooltip = true;

    
    //Show Session Vars in Log
    $this->warehouseService()->showSessionVars();

    \Log::info($this->log . 'Init|END');

  }

  /**
   * CLICK EVENT
   * Process Tooltip (Keep,Close)
   */
  public function processTooltip($process)
  {
    \Log::info($this->log . 'processTooltip: '.$process);

    if($process=="keep"){
      //Save in Session
      request()->session()->put('showTooltip',false);
    }

    //Close in Frontend
    $this->activeTooltip = false;

  }

  //|--------------------------------------------------------------------------
  //| Render
  //|--------------------------------------------------------------------------
  /**
   * @return mixed
   */
  public function render()
  { 

    return view($this->view);

  }

}
