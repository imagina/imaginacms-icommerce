<?php

namespace Modules\Icommerce\Support;

use Modules\Icommerce\Entities\ProductDiscount;

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
        "discount" => $item->product->discount ?? null,
        "tax" => 0,
        "reward" => 0,
        "productOptionValues" => (count($item->productOptionValues)>0) ? $item->productOptionValues : null
        ]);

      if(isset($item->product->discount->id)){

        \Log::info("Discount id: ".$item->product->discount->id);
        \Log::info([$item->product->discount]);
        $productDiscount = ProductDiscount::find($item->product->discount->id);
        $productDiscount->quantity_sold += (int)$item->quantity;
        $productDiscount->save();
      }
    }
    
    return $products;
    

  }


}