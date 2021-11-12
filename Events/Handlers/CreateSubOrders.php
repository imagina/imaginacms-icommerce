<?php

namespace Modules\Icommerce\Events\Handlers;


class CreateSubOrders
{

   
    public function handle($event = null)
    {
       

//        $order = $event->order;
//
//        $orderItemsByOrganization = $order->orderItems->keyBy("organization_id");
//        // Get Products from Order
//        foreach($order->orderItems as $item){
//
//          if($item->product->points>0){
//
//            $points = $item->product->points * $item->quantity;
//
//            $data = [
//              'user_id' => $order->customer_id,
//              'pointable_id' => $item->product->id,
//              'pointable_type' => get_class($item->product),
//              'description' => 'Puntos por comprar Producto: '.$item->product->name,
//              'points' => $points
//            ];
//
//            // Create Point
//            $pointCreated = app("Modules\Ipoint\Services\PointService")->create($data);
//
//          }
//
//        }


    }
    
}