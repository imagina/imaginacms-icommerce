<?php

namespace Modules\Icommerce\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Modules\Iprofile\Entities\Address as Address;
use Illuminate\Support\Facades\Route;


class WarehouseLocator extends Component
{
  public $layout;
  public $view;
  public $log;

  public $user;
  public $warehouse;
  public $shippingAddress;
  public $shippingMethods; //Config
  public $shippingMethodName;

  public $showAddressForm;
  public $chooseOtherWarehouse;
  public $tabSelected;

  public $provinces;
  public $cities;
  public $mapPickup;
  public $warehousesLocation;
  public $warehouseSelectedFromMap;
  public $showNotWarehouses;
  public $disabledBtnConfirm;
  public $loading;

  public $readyToLoad = false;
  
  /**
  * LISTENERS
  */
  protected $listeners = [
      'addressAdded' => 'checkAddress',
      'cleanWarehouseAlert',
      'cancelledNewAddress' => 'changeShowAddressForm',
      'shippingAddressChanged' => 'checkAddress',
      'markerSelectedFromMap',
      'updateTooltipStatus',
      'confirmData'
  ];
    
  /**
   * MOUNT
   */
  public function mount(
    $layout = 'warehouse-locator-layout-1',
    $warehouse, 
    $shippingAddress,
    $shippingMethods          
  ){
      $this->log = "Icommerce::Livewire|WarehouseLocator|";
      $this->layout = $layout;
      $this->view = "icommerce::frontend.livewire.warehouse-locator.layouts.$this->layout.index";

    
      //Default values
      $this->user = \Auth::user() ?? null;
      $this->warehouse = $warehouse;
      $this->shippingAddress = $shippingAddress;
      $this->shippingMethods = $shippingMethods;

      //Vars to Show and Hide HTML
      $this->showAddressForm = false;
      $this->chooseOtherWarehouse = false;
      $this->tabSelected = $this->shippingMethods['delivery'];
      $this->warehouseSelectedFromMap = null;
      $this->showNotWarehouses = false;
      $this->disableBtnConfirm = false;
      $this->loading = false;
      
      //Init Process
      $this->getAllShippingAddressFromUser();
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
  * @return addressRepository
  */
  public function addressRepository()
  {
    return app('Modules\Iprofile\Repositories\AddressRepository');
  }

  private function provinceRepository()
  {
    return app('Modules\Ilocations\Repositories\ProvinceRepository');
  }

  private function cityRepository()
  {
    return app('Modules\Ilocations\Repositories\CityRepository');
  }

  /**
  * @return warehouseService
  */
  public function warehouseService()
  {
    return app('Modules\Icommerce\Services\WarehouseService');
  }
  
  /**
  *  Get All Shipping address
  */
  public function getAllShippingAddressFromUser()
  { 
    if (isset($this->user->id)) {
      $this->userShippingAddresses = $this->user->addresses()->where("type", "shipping")->get();
    }else{
        $this->userShippingAddresses = collect([]);
    }
  }

  /**
   * INIT
   */
  public function init()
  {

    //Shipping Method Selected
    if (!is_null(session("shippingMethodName"))){
      $this->shippingMethodName = session("shippingMethodName");
      $this->tabSelected = session("shippingMethodName");
    }

  }

  /**
   * Init Provinces | Case Tab Pickup
   */
  private function initProvinces()
  {

    \Log::info($this->log.'Init Provinces');

    if(!empty($this->warehouse)) $countryId = $this->warehouse->country_id;
   
    if (isset($countryId)) {
      $params = ["filter" => ["countryId" => $countryId ?? null,"order" => ["way"=> "asc", "field" => "name"]]];
      
      //Get Setting
      $provincesIso2  = json_decode(setting('icommerce::availableProvincesMap',null,null));
      //Add Filter
      if(!is_null($provincesIso2) && count($provincesIso2)>0){
        $params["filter"]['iso2'] = $provincesIso2;
      }

      $this->provinces = $this->provinceRepository()->getItemsBy(json_decode(json_encode($params)));

    } else {
      $this->provinces = collect([]);
    }
   
  }

  /**
   * Init Provinces | Case Tab Pickup
   */
  private function initCities()
  { 
    
    $this->cities = collect([]);
    $this->showNotWarehouses = false;

    if(!empty($this->mapPickup["state_id"])){
      $provinceId = $this->mapPickup["state_id"];
    }else{
      if(!empty($this->warehouse)) 
        $provinceId = $this->warehouse->province_id;
    }
    //\Log::info($this->log.'Init Cities from Province: '.$provinceId);

    if(isset($provinceId)) {
      \Log::info($this->log.'Init Cities');

      //Get Setting
      $citiesId  = json_decode(setting('icommerce::availableCitiesMap',null,null));
      //Add Filter
      if(!is_null($citiesId) && count($citiesId)>0){
        //Get Only selecteds
        $params["filter"]['id'] = $citiesId;
      }else{
        //Get all cities for the province
        $params = ["filter" => ["provinceId" => $provinceId ?? null,"order" => ["way"=> "asc", "field" => "name"]]];
      }

      $this->cities = $this->cityRepository()->getItemsBy(json_decode(json_encode($params)));
    }

  }

  /**
   * UPDATE GENERAL
   */
  public function updated($name, $value)
  {
    \Log::info($this->log.'Updated General: '.$name.' | value: '.$value);

    switch ($name) {
      case 'mapPickup.country':
        if (!empty($value)) {
          $this->mapPickup["country_id"] = $this->countries->where("iso_2", $value)->first()->id;
          $this->initProvinces();
        }
        break;

      case 'mapPickup.province':
        if (!empty($value)) {
          $this->mapPickup["state_id"] = $this->provinces->where("id", $value)->first()->id;
          $this->initCities();
        }
        break;

      case 'mapPickup.city':
          if (!empty($value)) {
            $this->setWarehousesLocation();
          }
          break;
      case 'chooseOtherWarehouse':
            $this->otherWarehousesSelected($value);
            break;
    }

  }

  /**
   *  Get and Set Warehouses Location to City
   */
  public function setWarehousesLocation()
  {

    \Log::info($this->log.'setWarehousesLocation|CityId: '.$this->mapPickup["city"]);
    $this->warehousesLocation = [];
    $this->showNotWarehouses = false;
    $this->warehouseSelectedFromMap = null;
    
    //Warehouses to the City Selected in Map
    $params['filter']['city_id'] = $this->mapPickup["city"];
    $params['filter']['status'] = 1;
    $warehouses = $this->warehouseRepository()->getItemsBy(json_decode(json_encode($params)));

    //Check warehouses
    if(!is_null($warehouses) && count($warehouses)>0){
      foreach ($warehouses as $key => $warehouse) {

        \Log::info($this->log.'setWarehousesLocation|warehouse: '.$warehouse->id);
        array_push($this->warehousesLocation, [
          'lat' => $warehouse->lat,
          'lng' => $warehouse->lng,
          'title' =>  $warehouse->title,
          'id' => $warehouse->id,
          'address' => $warehouse->address, //Se agrego aqui para ser reutilizado
          'province' => $warehouse->province->name,//Se agrego aqui para ser reutilizado
          'city' => $warehouse->city->name//Se agrego aqui para ser reutilizado
        ]);

      }

    }else{
      $this->showNotWarehouses = true;
    }

  }

  /**
   * LISTENER | addressAdded | shippingAddressChanged
   * @param $addressData (array)
   */
  public function checkAddress($addressData)
  {

    \Log::info($this->log.'checkAddress');

    if(!empty($addressData)){

      $this->disabledBtnConfirm = false;

      //Added
      if(isset($addressData['id'])){
        $criteria = $addressData['id'];
      }else{
        //Shipping Address Changed
        $criteria = $addressData;
      }
    
      //Search Collection Entity
      $params['include'] = [];
      $address = $this->addressRepository()->getItem($criteria,json_decode(json_encode($params)));

      //Get warehouse to the address
      $warehouseToAddress = $address->warehouse;

      //The address have a warehouse
      if (!is_null($warehouseToAddress)) {
        \Log::info($this->log . 'Shipping Address has a warehouse');
        $warehouse = $warehouseToAddress;
      }else{
        //Proccess to get a Warehouse to the Address
        $warehouseProcess = $this->warehouseService()->getWarehouseToAddress($address);

        //Get Warehouse Data
        $warehouse = $warehouseProcess['warehouse'];

        //Save Warehouse for this Address
        $address->warehouse_id = $warehouse->id;
        $address->save();
      }

      //Update Livewire Vars
      $this->shippingAddress = $address;
      $this->warehouse = $warehouse;
      
      //Save in Session
      //session(['warehouse' => $this->warehouse]);
      //session(['shippingAddress' => $this->shippingAddress]);

      //Show Session Vars in Log
      $this->warehouseService()->showSessionVars();

      //Close Address Form
      $this->showAddressForm = false;

      //Verifying that it was a nearby warehouse
      if(isset($warehouseProcess['nearby'])){
        //Show Sweet Alert in frontend
        session(['warehouseAlert' => true]);
        //Reload Page
        return redirect(request()->header('Referer'));

      }else{

        //OJO CON ESTO / PROBAR
        $this->getAllShippingAddressFromUser();
        
      }

    }else{
      $this->shippingAddress = null;
      $this->disabledBtnConfirm = true;
    }

  }

  /**
   * LISTENER
   * Clear Warehouse Alert
   */
  public function cleanWarehouseAlert()
  {
    session(['warehouseAlert' => null]);
  }

  /**
   * LISTENER
   * Clear Warehouse Alert
   */
  public function changeShowAddressForm()
  {
    $this->showAddressForm = false;
  }

  /**
   * Listener
   * Marker is selected in Map
   */
  public function markerSelectedFromMap($warehouseId)
  {
    \Log::info($this->log.'markerSelectedFromMap: '.$warehouseId);

    //Re use this array to search data
    $key = array_search($warehouseId, array_column($this->warehousesLocation, 'id'));
    
    //To the front View
    $this->warehouseSelectedFromMap = $this->warehousesLocation[$key];

    //Show BTN Confirm
    $this->disabledBtnConfirm = false;
   
  }

  /**
   * Listener
   * User clicked in button "keep" inside Tooltip
   */
  public function updateTooltipStatus()
  {
    
    //Save in Session
    session(['showTooltip' => false]);

  }

  /**
   * EVENT CLICK
   * When Click in a TAB
   */
  public function changeTabSelected($tabSelected)
  {
    \Log::info($this->log.'changeTabSelected|To: '.$tabSelected);

    $this->tabSelected = $tabSelected;
    
    //Is tab Pickup but button confirm was disabled
    if($tabSelected==$this->shippingMethods['pickup'] && $this->disabledBtnConfirm){
      $this->disabledBtnConfirm = false;
    }

    //Is tab Delivery 
    if($tabSelected==$this->shippingMethods['delivery']){
      //shipping address not selected
      if(is_null($this->shippingAddress)){
        //Not Show BTN Confirm
        $this->disabledBtnConfirm = true;
      }else{
        //Show BTN Confirm
        $this->disabledBtnConfirm = false;
      }

      //El usuario estaba en Pickup, escogiendo la ubicacion pero se cambio de tab
      if($this->chooseOtherWarehouse){
          $this->chooseOtherWarehouse = false;
          $this->warehouseSelectedFromMap = null;
      }
      
    }

  }

  /**
   * EVENT CLICK
   * Confirm BTN | Shipping Method Selected
   */
  public function confirmData()
  {

    \Log::info($this->log.'confirmData');

    //Helper|Isite
    //clearResponseCache();

    $this->loading = true;
    $this->disabledBtnConfirm = true;

    //Save in Session
    session(['shippingMethodName' => $this->tabSelected]);

    //Case Pickup
    if($this->tabSelected==$this->shippingMethods['pickup']){

      //Shipping Address Selected (From Delivery)
      if(!is_null(session('shippingAddress'))){
        //Para que en el layout no muestre la direccion del Usuario sino la del Warehouse
        session(['shippingAddress' => null]);
        //No entre a la validacion donde revisa las direcciones del usuario y asigna como seleccionada | Warehouse Component Blade
        session(['shippingAddressChecked' => true]);
      }
      
      //User selected a warehouse from Map
      if(!is_null($this->warehouseSelectedFromMap)){
        
        $criteria = $this->warehouseSelectedFromMap['id'];
        //Get All Data
        $warehouseSelected = $this->warehouseRepository()->getItem($criteria);
        //Save in Session
        session(['warehouse' => $warehouseSelected]);
      }
      
    }else{
      //Case Delivery
      
      //Save in Session
      session(['warehouse' => $this->warehouse]);
      session(['shippingAddress' => $this->shippingAddress]);

    }

    //Show Session Vars in Log
    //$this->warehouseService()->showSessionVars();

    //Reload Page
    //return redirect(request()->header('Referer'));

    //Reload Page
    $this->dispatchBrowserEvent('refresh-page');

  }

  /**
   * Updated | ChooseOtherWarehouses Var
   * Click Button Other Warehouses
   */
  public function otherWarehousesSelected($value)
  {

    //Case Open Ilocations
    if ($value) {
      
      if(is_null($this->provinces)) $this->initProvinces();
      //Disable BTN Confirm
      $this->disabledBtnConfirm = true;

    }else{

      //Case | Click in "Back BTN"
     
      $this->warehouseSelectedFromMap = null;
      //Active BTN Confirm
      $this->disabledBtnConfirm = false;
      
    }

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
  public function getWarehouseFromSession()
  {
    
    $this->warehouse = session("warehouse");
    return $this->warehouse;

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
      'warehouse' => $this->readyToLoad ? $this->getWarehouseFromSession() : null
    ]);
   
  }

}
