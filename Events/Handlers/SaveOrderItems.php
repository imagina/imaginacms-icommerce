<?php

namespace Modules\Icommerce\Events\Handlers;

//Support
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

    		$cartProductOptions = $item["cartProductOption"];
    		unset($item["cartProductOption"]);

    		// Create Order Items
    		$orderItem = $order->orderItems()->create($item);
			
    		if($cartProductOptions!=null){
    			 foreach ($cartProductOptions as $productOption) {

    			 	// Fix Data OrderOption
      				$supportOrderOption = new orderOptionSupport();
      				$dataOrderOption = $supportOrderOption->fixData($order->id,$orderItem->id,$productOption);

					// Create Order Option
					$order->orderOption()->create($dataOrderOption);

				}
			}
			
    		
    	}// End Foreach

    }// If handle

    

}
