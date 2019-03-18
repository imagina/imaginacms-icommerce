<?php

namespace Modules\Icommerce\Support;

class Cart
{

    public function fixProductsAndTotal($cart){

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

        return $dataMethods;

    }

    

}