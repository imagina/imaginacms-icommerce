<?php

namespace Modules\Icommerce\Services;

class WarehouseService
{
    
    private $warehouseRepository;
    private $log; 

    /**
     * Construct
     */
    public function __construct()
    {   
        $this->log = "Icommerce::Services|WarehouseService|";
        $this->warehouseRepository = app('Modules\Icommerce\Repositories\WarehouseRepository');
    }

    /**
    *  Show Sessions in Log
    */
    public function showSessionVars()
    {

        $warehouse = request()->session()->get('warehouse');
        $shippingMethodName = request()->session()->get('shippingMethodName');
        $shippingAddress = request()->session()->get('shippingAddress');

        $shippingAddressChecked = request()->session()->get('shippingAddressChecked');
        $warehouseAlert= request()->session()->get('warehouseAlert');
        $showTooltip = request()->session()->get('showTooltip');

        \Log::info($this->log.'showSessionVars|===============================');

        if(isset($warehouse))
            \Log::info($this->log.'showSessionVars|warehouseId: '.$warehouse->id);
        if(isset($shippingAddress))
            \Log::info($this->log.'showSessionVars|shippingAddressId: '.$shippingAddress->id);
        if(isset($shippingMethodName))
            \Log::info($this->log.'showSessionVars|shippingMethodName: '.$shippingMethodName);
        if(isset($shippingAddressChecked))
            \Log::info($this->log.'showSessionVars|shippingAddressChecked: '.$shippingAddressChecked);
        if(isset($warehouseAlert))
            \Log::info($this->log.'showSessionVars|warehouseAlert: '.$warehouseAlert);
        if(isset($showTooltip))
            \Log::info($this->log.'showSessionVars|showTooltip: '.$showTooltip);

        \Log::info($this->log.'showSessionVars|===============================');
       
    }

    /**
    *  Clean Sessions Vars
    */
    public function cleanSessionVars()
    {

        \Log::info($this->log.'cleanSessionVars');

        session()->forget('warehouse');
        session()->forget('shippingMethodName');
        session()->forget('shippingAddress');
        session()->forget('shippingAddressChecked');
        session()->forget('warehouseAlert');
        session()->forget('showTooltip');

    }

    /**
    * Process to get a Warehouse to Address
    */
    public function getWarehouseToAddress($address)
    {
        \Log::info($this->log.'getWarehouseToAddress|AddressId: '.$address->id);
        $warehouseSelected = null;
        $nearbyWarehouse = null;
        
        $params['include'] = ['polygon'];
        $params['filter']['status'] = 1;
        $warehouses = $this->warehouseRepository->getItemsBy(json_decode(json_encode($params)));

        \Log::info($this->log.'getWarehouseToAddress|Address: '.$address->address_1.'| City: '.$address->city);
        //Buscar al menos un warehouse que cubra esa direccion
        \Log::info($this->log.'getWarehouseToAddress|Searching in Warehouses:');
        foreach ($warehouses as $key => $warehouse) {
            $polygon = $warehouse->polygon;
            if(!is_null($polygon)){
                \Log::info($this->log.'getWarehouseToAddress|WarehouseId: '.$warehouse->id.' | Title: '.$warehouse->title);
                
                //Get Points from Polygon
                $points = $polygon->points;

                //Get Vertices
                $vsX = [];
                $vsY = [];
                foreach ($points as $key => $point) {
                array_push($vsX,$point['lng']);
                array_push($vsY,$point['lat']);
                }
                //Get points from polygon
                $pointsPolygon = count($vsX) - 1;
                
                //Warehouse to Address Found 
                if($this->isInPolygon($pointsPolygon, $vsX, $vsY, $address->lng,$address->lat)){
                    \Log::info($this->log.'getWarehouseToAddress|FOUND to Polygon in WarehouseId: '.$warehouse->id);

                    //Return 
                    return [
                        'warehouse' => $warehouse
                    ];

                }else{
                    //The warehouse does not cover the address
                    //Se aprovecha y determina la distancia
                    if(is_null($nearbyWarehouse)){
                        $nearbyWarehouse = [
                            'warehouse' => $warehouse,
                            'distance' => $this->calcultaDistance($warehouse,$address)
                        ];
                    }else{
                        //Ya se guardo uno, comparar la data
                        $distance = $this->calcultaDistance($warehouse,$address);
                        if($distance<$nearbyWarehouse['distance']){
                            $nearbyWarehouse = [
                                'warehouse' => $warehouse,
                                'distance' => $distance
                            ];
                        }
                    }
      
                }
            
            }
        }

        //No se encontró un warehouse que cubra esa direccion, se le asigna el warehouse mas cercano
        \Log::info($this->log.'getWarehouseToAddress|Nearby Assigned WarehouseId: '.$nearbyWarehouse['warehouse']->id);
        //Return 
        return [
            'warehouse' => $nearbyWarehouse['warehouse'],
            'nearby' => true
        ];

    }

    /**
    * @param $pointsPolygon (number vertices - zero-based array)
    * @param $vsX (Vertices X)
    * @param $vsY (Vertices Y)
    */
    public function isInPolygon($pointsPolygon, $vsX, $vsY, $lngX, $latY)
    {   

        //dd($pointsPolygon,"LNG:",$vsX,"LAT:",$vsY,"Address LNG:".$lngX,"Address LAT: ".$latY);

        $i = $j = $c = 0;
        for ($i = 0, $j = $pointsPolygon ; $i < $pointsPolygon; $j = $i++) {
        if ( (($vsY[$i]  >  $latY != ($vsY[$j] > $latY)) &&
        ($lngX < ($vsX[$j] - $vsX[$i]) * ($latY - $vsY[$i]) / ($vsY[$j] - $vsY[$i]) + $vsX[$i]) ) )
            $c = !$c;
        }

        return $c;
    }


    /*
    * Calcular distancia entre 2 Items
    */
    public function calcultaDistance($itemA,$itemB)
    {

        //Transformacion a Radianes
        $rlat0 = deg2rad($itemA['lat']);
        $rlng0 = deg2rad($itemA['lng']);
        $rlat1 = deg2rad($itemB['lat']);
        $rlng1 = deg2rad($itemB['lng']);

        //Diferencia entre valores
        $lonDelta = $rlng1 - $rlng0;

        //Radio de la Tierra: 6371Km | 6371000 Mts,
        //Usando ley esférica de los cosenos
        $distance = round((6371000 *
            acos(
                cos($rlat0) * cos($rlat1) * cos($lonDelta) +
                sin($rlat0) * sin($rlat1)
            )
        ),2);
        
        \Log::info($this->log."Distance Aprox: ".$distance." Mts");

        return $distance;

    }


}