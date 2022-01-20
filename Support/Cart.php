<?php

namespace Modules\Icommerce\Support;

class Cart
{
  
  public function fixProductsAndTotal($cart)
  {
    
    $products = [];
    
    foreach ($cart->products ?? [] as $cartProduct) {
      array_push($products, [
        "title" => $cartProduct->product->name,
        "price" => $cartProduct->product->price,
        "product_id" => $cartProduct->product_id,
        "total" => $cartProduct->product->price * $cartProduct->quantity,
        "reference" => $cartProduct->product->reference,
        "length" => $cartProduct->product->length,
        "width" => $cartProduct->product->width,
        "height" => $cartProduct->product->height,
        "weight" => $cartProduct->product->weight,
        "freeshipping" => $cartProduct->product->freeshipping,
        "quantity" => $cartProduct->quantity
      ]);
    }
    
    $dataMethods['products'] = array(
      "items" => json_encode($products),
      "total" => $cart->total
    );
    
    return $dataMethods;
    
  }
  
  
}