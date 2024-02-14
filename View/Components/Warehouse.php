<?php

namespace Modules\Icommerce\View\Components;

use Illuminate\View\Component;

class Warehouse extends Component
{

  //Base Layout
  public $log;
  public $layout;
  public $layoutLocator;
  private $view;

  public $warehouseLocatorId;
  public $user;
  public $icon;
  public $text;
  public $iconClass;
  public $iconOrderRight;
  public $textClass;
  public $iconStyle;
  public $textStyle;
  public $iconStyleHover;
  public $textStyleHover;
  public $warehouseLocatorClass;
  public $warehouseLocatorStyle;
  public $warehouseLocatorStyleHover;
  public $addressClass;
  public $addressStyle;
  public $addressStyleHover;
  public $iconModal;
  public $titleModal;
  public $subtitleModal;
  public $activeTooltip;
  public $locale;
  public $address;
  public $shippingMethodsConfig;

  //Base 
  public $warehouse;
  public $shippingMethods;
  public $shippingAddress;
  public $userShippingAddresses;

  /**
   * @return void
   */
  public function __construct(
    $layout = "warehouse-layout-1",
    $layoutLocator = "tabs",
    $warehouseLocatorId = null,
    $icon = null,
    $text = null,
    $iconOrderRight = false,
    $iconClass = '',
    $textClass = '',
    $iconStyle = null,
    $textStyle = null,
    $iconStyleHover = null,
    $textStyleHover = null,
    $warehouseLocatorClass = '',
    $warehouseLocatorStyle = null,
    $warehouseLocatorStyleHover = null,
    $addressClass = '',
    $addressStyle = null,
    $addressStyleHover = null,
    $iconModal = null,
    $titleModal = null,
    $subtitleModal = null,
    $shippingMethodsConfig = null
  ) {

    $this->log = "Icommerce::Components|Warehouse|";
    $this->layout = $layout;
    $this->layoutLocator = $layoutLocator;  //Layout To Warehouse Locator | Livewire Component
    $this->view = "icommerce::frontend.components.warehouse.layouts." . $layout . ".index";

    $this->warehouseLocatorId = $warehouseLocatorId ?? uniqid('warehouse-locator');
    $this->icon = $icon;
    $this->text = $text;
    $this->iconOrderRight = $iconOrderRight;
    $this->iconClass = $iconClass;
    $this->textClass = $textClass;
    $this->iconStyle = $iconStyle;
    $this->textStyle = $textStyle;
    $this->iconStyleHover = $iconStyleHover;
    $this->textStyleHover = $textStyleHover;
    $this->warehouseLocatorClass = $warehouseLocatorClass;
    $this->warehouseLocatorStyle = $warehouseLocatorStyle;
    $this->awarehouseLocatorStyleHover = $warehouseLocatorStyleHover;
    $this->addressClass = $addressClass;
    $this->addressStyle = $addressStyle;
    $this->addressStyleHover = $addressStyleHover;
    $this->iconModal = $iconModal;
    $this->titleModal = $titleModal;
    $this->subtitleModal = $subtitleModal;

    //Config Shipping Methods
    $configName = $shippingMethodsConfig ?? 'asgard.icommerce.config.warehouseShippingMethods';
    //Shipping Method Base
    $this->shippingMethods = config($configName);

    //Default values
    $this->user = \Auth::user() ?? null;
    $this->activeTooltip = false;

    //Init Process
    $this->init();
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
   * Set default Warehouse
   */
  public function setDefaultWarehouse()
  {
    \Log::info($this->log . 'setDefaultWarehouse');

    $params['filter']['field'] = "default";
    $default = $this->warehouseRepository()->getItem(true, json_decode(json_encode($params)));

    if (!is_null($default)) {
      $this->warehouse = $default;
      session(['warehouse' => $this->warehouse]);
    }
  }

  /**
   *  Set Vars with Sessions
   */
  public function setInitVars()
  {
    \Log::info($this->log . 'setInitVars');

    //Clean Values | Only Testing
    //$this->warehouseService()->cleanSessionVars();

    //Shipping Method Name DEFAULT
    if (is_null(session("shippingMethodName")))
      session(['shippingMethodName' => $this->shippingMethods['pickup']]);

    if (!is_null(session("warehouse"))) {
      $this->warehouse = session("warehouse");
    }

    if (!is_null(session("shippingAddress"))) {
      $this->shippingAddress = session("shippingAddress");
    }

    if (!is_null(session("showTooltip"))) {
      $this->activeTooltip = session("showTooltip");
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
      $this->shippingAddress = $shippingAddress ;
      //Save in Session Shipping Address
      session(['shippingAddress' => $this->shippingAddress]);
    } else {
      \Log::info($this->log . 'getAndsetShippingAddress|User has no address by default');
      session(['shippingAddress' => null]);
    }
    
  }

  /**
   *  INIT PROCESS
   */
  public function init()
  {
    \Log::info($this->log . 'INIT');

    //Set Livewire Variables with Session Variables
    $this->setInitVars();

    //Case: User NOT LOGGED AND Null Warehouse to not repeat after process

    if (is_null($this->user) && is_null($this->warehouse)) {
      \Log::info($this->log . 'User NOT LOGGED');
      //Assign Default Warehouse
      $this->setDefaultWarehouse();
    } else {

      //Case: User LOGGED
      if (!is_null($this->user)) {
        \Log::info($this->log . 'User LOGGED');

        //Check Shipping Address NULL and Process to Shipping Address with Warehouse
        if (is_null($this->shippingAddress) && is_null(session("shippingAddressChecked"))) {

          //Get and Set Shipping Address default from the User
          $this->getAndSetShippingAddress();

          //User doesn't have Shipping Address
          if (is_null($this->shippingAddress)) {

            //Assign Default Warehouse
            $this->setDefaultWarehouse();
            //Show tooltip
            $this->activeTooltip = true;

            session(['shippingAddressChecked' => true]);

          } else {
            //User has a Shipping Address

            //Get warehouse to the address
            $warehouseToAddress = $this->shippingAddress->warehouse;

            //The address have a warehouse
            if (!is_null($warehouseToAddress)) {
              \Log::info($this->log . 'Shipping Address has a warehouse');
              $warehouse = $warehouseToAddress;
            } else {
              //Proccess to get a Warehouse to the Address
              $warehouseProcess = $this->warehouseService()->getWarehouseToAddress($this->shippingAddress);

              //Get Warehouse Data
              $warehouse = $warehouseProcess['warehouse'];

              //Save Warehouse for this Address
              $this->shippingAddress->warehouse_id = $warehouse->id;
              $this->shippingAddress->save();

              //Verifying that it was a nearby warehouse
              if (isset($warehouseProcess['nearby'])) {
                //Show Sweet Alert in frontend
                session(['warehouseAlert' => true]);
                //Reload Page
                return redirect(request()->header('Referer'));
              }
            }

            if (!is_null($warehouse)) {
              //Set Sessions
              $this->warehouse = $warehouse;
              session(['warehouse' => $warehouse]);
            }
          }
        }

      }else{
        
        //User Not Logged but at one point the shippingAddress session variable was created
        if(!is_null(session("shippingAddress"))) {
          session(['shippingAddress' => null]);
        }

      }
    }

    //Show Tooltip
    if (is_null($this->shippingAddress) && is_null(session("showTooltip"))) $this->activeTooltip = true;

    \Log::info($this->log . 'END');

    //Show Session Vars in Log
    $this->warehouseService()->showSessionVars();
  }


  /**
   * Render
   */
  public function render()
  {

    return view($this->view);
  }
}
