<?php

namespace Modules\Icommerce\Events\Handlers;

use Illuminate\Http\Request;
use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Entities\OrderStatusHistory;
use Modules\Icommerce\Entities\PaymentMethod;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;
use Modules\Icommerce\Http\Controllers\Api\OrderApiController;

class UpdateSubOrdersStatus
{
  
  
  public function handle($event = null)
  {
    
    
    $data = $event->order;
    if (isset($data['order_id']) && isset($data['status'])) {
      $order = Order::where('id', $data['order_id']);
    }
   
    //solo si es una orden padre se entra a buscar las hijas para actualizarlas todas
    if (isset($order->id) && (!isset($order->parent_id) || (empty($order->parent_id) && $order->children->isNotEmpty()))) {
      
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