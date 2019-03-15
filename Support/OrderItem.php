<?php

namespace Modules\Icommerce\Support;

class OrderItem
{

  public function fixData($items){

    $products = [];

    foreach($items as $item){

      array_push($products, [
        "product_id" => (int)$item->product_id,
        "title" => $item->product->name,
        "reference" => $item->product->reference,
        "quantity" => (int)$item->quantity,
        "price" => floatval($item->price),
        "total" => $item->getSubTotalAttribute(),
        "tax" => 0,
        "reward" => 0,
        "cartProductOption" => (count($item->cartproductoption)>0) ? $item->cartproductoption : null
        ]);
    }
    
    return $products;
    

  }


}