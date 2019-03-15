<?php

namespace Modules\Icommerce\Support;

class ShippingMethod
{

    public function fixDataSend($cart,$addressShipping,$areaMapId){

        $products = [];
      
        foreach($cart->products as $product){
            array_push($products, [
            "title" => $product->product->title,
            "price" => $product->price,
            "weight" => $product->product->weight,
            "length" => $product->product->lenght,
            "width" => $product->product->width,
            "height" => $product->product->height,
            "freeshipping" => $product->product->freeshipping,
            "quantity" => $product->quantity
            ]);
        }

        $dataMethods['products'] = array(
            "items" => json_encode($products),
            "total" => $cart->getTotalAttribute()
        );

        $options = [];

        if($addressShipping->country){
          $options['countryCode'] = $addressShipping->country->iso_2;
          $options['country'] = $addressShipping->country->translate('en')->name;
        }
            
        if($addressShipping->zip_code)
          $options['postalCode'] = $addressShipping->zip_code; 

        if($addressShipping->city){
          $options['city'] = $addressShipping->city->translate('en')->name;
          $options['cityCode'] = $addressShipping->city->code; //Optional
        }

        if($addressShipping->province){
          $options['zone'] = $addressShipping->province->translate('en')->name; 
          $options['zoneCode'] = $addressShipping->province->iso_2; //Optional
        }
        
        if(!empty($areaMapId))
          $options['areaMapId'] = $areaMapId;

        $dataMethods['options'] = $options;

        return $dataMethods;

    }

    public function searchPriceWithName($shippingMethods,$dataName){
        
        foreach ($shippingMethods as $shipping) {

            if($shipping->calculations->status=="success"){
              if($shipping->calculations->items==null){
                if($shipping->name==$dataName){
                  return $shipping->calculations->price;
                }
              }else{
                foreach($shipping->calculations->items as $item){
                  if($item->name==$dataName){
                    return $item->price;
                  }
                }
              }// If items
            }// If success
          
        }
    }

}