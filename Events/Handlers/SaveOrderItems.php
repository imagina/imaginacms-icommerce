<?php

namespace Modules\Icommerce\Events\Handlers;

//Support
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Support\OrderOption as orderOptionSupport;

class SaveOrderItems
{
   
    public function __construct()
    {
        
    }

    public function handle($event)
    {
        $order = $event->order;
        $items = $event->items;

    	foreach ($items as $item) {

    		$cartProductOptionsValues = $item["productOptionValues"];
    		unset($item["productOptionValues"]);

    		// Create Order Items
    		$orderItem = $order->orderItems()->create($item);
    		$product = Product::find($item["product_id"]);
    		
    		if(isset($product->id) && $product->subtract){
          $product->quantity = $product->quantity - $item["quantity"];
          $product->save();
        }
			
    		if($cartProductOptionsValues!=null){
    			 foreach ($cartProductOptionsValues as $productOptionValue) {

    			 	// Fix Data OrderOption
      				$supportOrderOption = new orderOptionSupport();
      				$dataOrderOption = $supportOrderOption->fixData($order->id,$orderItem->id,$productOptionValue);

					// Create Order Option
					$order->orderOption()->create($dataOrderOption);

				}
			}
			
    		
		}// End Foreach
		
    }// If handle

    

}
