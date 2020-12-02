<?php

namespace Modules\Icommerce\Events\Handlers;

//Support
use Modules\Icommerce\Entities\Product;

class UpdatePriceProductLists
{

    public function __construct()
    {

    }

    public function handle($event)
    {
        $productList = $event->productList;
        if($productList->priceList->criteria=="percentage"){
          $product=$productList->product;
          $value=($product->price*$productList->priceList->value)/100;//Example value pricelist = 5 (Calculate 5%)
          $price=$product->price;
          if($productList->priceList->operation_prefix=="-"){
            $price-=$value;
          }else{
            $price+=$value;
          }
          $productList->price=$price;
          $productList->update();
        }

    }//  handle



}
