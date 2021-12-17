<?php

namespace Modules\Icommerce\Events\Handlers;

use Illuminate\Http\Request;
use Modules\Icommerce\Entities\OrderStatusHistory;
use Modules\Icommerce\Entities\PaymentMethod;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;

class UpdateSubOrdersStatus
{
  
  
  public function handle($event = null)
  {
    
    
    $order = $event->order;
   
    //solo si es una orden padre se entra a buscar las hijas para actualizarlas todas
    if (!isset($order->parent_id) || empty($order->parent_id) && $order->children->isNotEmpty()) {
      
      foreach ($order->children as $subOrder) {
        
        $orderStatusHistory = OrderStatusHistory::create([
          "order_id" => $subOrder->id,
          "status" => $order->status_id,
          "organization_id" => $subOrder->organization_id,
        ]);
        
        event(new OrderStatusHistoryWasCreated($orderStatusHistory));
        
      }
    }
  }
}