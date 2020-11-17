<?php

namespace Modules\Icommerce\Events\Handlers;


class DiscountStockProducts
{
   
    public function __construct()
    {
        
    }

    public function handle($event)
    {
        $order = $event->order;
        
        //Order is Proccesed
        if($order->status_id==13){

            foreach($order->orderItems as $item){

                $productQuantity = $item->product->quantity;
                $productQuantity -= $item->quantity;
                
                if($productQuantity<0)
                    $productQuantity = 0;
               
                $params = array('quantity' => $productQuantity);
                $item->product->update($params);
                
            }

        }// end If

    	
    }// If handle

    

}
