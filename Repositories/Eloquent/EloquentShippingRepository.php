<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ShippingRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentShippingRepository extends EloquentBaseRepository implements ShippingRepository
{

	public function getShippingsMethods($products,$postalCode=null,$countryCode=null,$country=null){
    	$shippingMethods = config('asgard.icommerce.config.shippingmethods');
    	$fixCollect = collect([]);
    	$resultMethods = collect([]);
        $initMethods = array("freeshipping","flatrate","localdelivery","iagree");
        $methodConfiguration = null;

        if(isset($shippingMethods) && count($shippingMethods)>0){

            // Items mixtos with Freeshipping and not freeshipping
            if(!icommerce_checkAllItemsFreeshipping($products["items"],$countryCode)){

                foreach ($shippingMethods as $key => $method) {
                    if(in_array($method['name'],$initMethods)){
                        try{
                            $shippingObjet = new $method['entity'];
                            $methodConfiguration = $shippingObjet->getData();
                            
                        } 
                        catch(\Exception $e){
                           $methodConfiguration = null; 
                        }

                        if($methodConfiguration != null && $methodConfiguration->status==1){
                            $methodConfiguration->configName = $method['name'];
                            $methodConfiguration->configTitle = $method['title'];

                            if($method['name']=="iagree")
                                $methodConfiguration->price = 0;

                            $resultMethods->push($methodConfiguration);
                        }

                    }else{

                        // Dinamic Methods Like UPS / USPS / all the News
                      $shippingObjet = new $method['entity'];
                      $methodConfig = $shippingObjet->getData();
                       
                        if($methodConfig->status==1){

                            if($postalCode!=null && $countryCode!=null){
                                
                                try {
                                    
                                    $Results = $method['init']($products,$postalCode,$countryCode,$country);

                                    $methodConfiguration=[
                                        "msj" => $Results["msj"],
                                        "configName" => $method['name'],
                                        "items" =>$Results["data"]

                                        // price, configTitle
                                    ];

                                } catch (\Exception $e) {
                                    $methodConfiguration=[
                                        "msj" => 'error',
                                        "configName" => $method['name'],
                                        "items" =>$e->getMessage()
                                    ];
                                }

                            }else{

                                 $methodConfiguration=[
                                    "msj" => "error",
                                    "configName" => $method['name'],
                                    "items" => $method['msjini']
                                ];
                            }

                            $resultMethods->push($methodConfiguration);
                           
                        } // If Method Status
                        
                    } // If InArray
        		}

            }else{

                // All the items have freeshipping
                $methodConfiguration=[
                    "msj" => "freeshipping",
                    "configName" => "notmethods",
                    "items" => "All the items have Freeshipping"
                ]; 

                $resultMethods->push($methodConfiguration);

            }
    	}

    	if(count($shippingMethods)==0 || ($resultMethods->count())==0)
    		$resultMethods = null;

    	return $resultMethods;
    }

}
