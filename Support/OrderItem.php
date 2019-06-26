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
        "reference" => $item->product->sku,
        "quantity" => (int)$item->quantity,
        "price" => floatval($item->product->price),
        "total" => $item->total,
        "tax" => 0,
        "reward" => 0,
        "productOptionValues" => (count($item->productOptionValues)>0) ? $item->productOptionValues : null
        ]);

    }
    
    return $products;
    

  }


}