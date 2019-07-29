<?php

namespace Modules\Icommerce\Support;

class ShippingMethod
{

    public function fixDataSend($data){

        $products = [];

        /*
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
        */

        $dataMethods['products'] = array(
          "cart_id" => $data->cart->id
        );
        
        

        if(isset($data->addressShipping->country)){
          $data['countryCode'] = $data->addressShipping->country->iso_2;
          $data['country'] = $data->addressShipping->country->translate('en')->name;
        }
            
        if(isset($data->addressShipping->zip_code))
          $data['postalCode'] = $data->addressShipping->zip_code;

        if(isset($data->addressShipping->city)){
          $data['city'] = $data->addressShipping->city->translate('en')->name;
          $data['cityCode'] = $data->addressShipping->city->code; //Optional
        }

        if(isset($data->addressShipping->province)){
          $data['zone'] = $data->addressShipping->province->translate('en')->name;
          $data['zoneCode'] = $data->addressShipping->province->iso_2; //Optional
        }
        
        if(!empty($data->areaMapId))
          $data['areaMapId'] = $areaMapId;

        if(!empty($data->shippingValue))
          $data['shippingValue'] = $shippingValue;

        $dataMethods['options'] = $data;

        return $dataMethods;

    }

    public function searchPriceByName($shippingMethods,$dataName){
        
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