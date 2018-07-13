<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\ShippingRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentShippingRepository extends EloquentBaseRepository implements ShippingRepository
{
  
  public function getShippingsMethods($products,$postalCode=null,$countryCode=null,$country=null){
    
    $shippingMethods = config('asgard.icommerce.config.shippingmethods');
    $resultMethods = collect([]);
    
    $methodConfiguration = null;
    
    if(isset($shippingMethods) && count($shippingMethods)>0){
      
      // Items mixtos with Freeshipping and not freeshipping
      if(!icommerce_checkAllItemsFreeshipping($products["items"],$countryCode)){
        
        
        foreach ($shippingMethods as $key => $method) {
          
          $status = setting($method["name"].'::status');
          
          if($status==1){
            
            // Informacion que retorna para el Frontend
            /*
                if msj is "success" and 'items' is not null
                    - Items has a list (array)

                if msj is "success" and items is null:
                    - Price will be defined (Number 0,1,2,3,4,5)
                    - PriceShow will be defined (true or false)

                if msj is "error":
                    - 'items' has an error msj (string)

                if msj is "freeshipping":
                    - 'items' has a msj (string)
            */
            
            // OJO ESTE IF DEBE IR EN EL MODULO QUE CORRESPONDA (UPS / USPS)
            //if($postalCode!=null && $countryCode!=null){
            
            
            try {
              
              $Results = $method['init']($products,$postalCode,$countryCode,$country);
              
              if(isset($Results["price"]))
                $price = $Results["price"];
              else
                $price = null;
              
              if(isset($Results["priceshow"]))
                $priceShow = $Results["priceshow"];
              else
                $priceShow = null;
              
              $methodConfiguration=[
                "msj" => trans($Results["msj"]),
                "configName" => $method['name'],
                "items" => $Results["data"],
                "configTitle" => trans($method['title']),
                "price" => $price,
                "priceShow" => $priceShow
              ];
              
            } catch (\Exception $e) {
              $methodConfiguration=[
                "msj" => 'error',
                "configName" => $method['name'],
                "items" =>$e->getMessage(),
                "configTitle" => $method['title']
              ];
            }
            
          }// status
          
          
          /*
             Si hubo un error en la validacion dentro del Modulo (UPS / USPS o el q sea)

             Debe retornar dentro de ese modulo:
                 - $response["msj"] = "error";
                 - $response["items"] = "Debe ingresar el codigo postal etc etc";
 
              Nota: Pueden ver el Helper de Iagree, como retorna los valores con price etc.

 El msj $method['msjini'] (Que es el msj del config icommerce) pudiera desaparecer
 Y el msj estaria en el retorno de cada Modulo:

   $response["items"] =  trans('icommerceups::configups.messages.msjini')
         */
          
          
          $resultMethods->push($methodConfiguration);
          
        }// foreach
        
      }else{
        
        // All the items have freeshipping
        $methodConfiguration=[
          "msj" => "freeshipping",
          "configName" => "notmethods",
          "items" => "All the items have Freeshipping",
          "configTitle" => "Not Methods"
        ];
        
        $resultMethods->push($methodConfiguration);
        
      }
    }
    
    
    
    if(count($shippingMethods)==0 || ($resultMethods->count())==0)
      $resultMethods = null;
    
    
    //dd($resultMethods);
    
    return $resultMethods;
  }
  
}
