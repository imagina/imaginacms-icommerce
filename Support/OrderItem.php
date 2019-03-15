<?php

namespace Modules\Icommerce\Support;

class OrderItem
{

  public function fixData($items){

    $products = [];

    foreach($items as $item){
      array_push($products, [
        "product_id" => $item->id,
        "title" => $item->product->name,
        "reference" => $item->product->reference,
        "quantity" => $item->quantity,
        "price" => floatval($item->price),
        "total" => $item->getSubTotalAttribute(),
        "tax" => 0,
        "reward" => 0
        ]);
    }
    
    return $products;
    

  }


}