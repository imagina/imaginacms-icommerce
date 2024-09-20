<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\Icommerce\Entities\Order;
use Modules\Icommerce\Entities\OrderStatusHistory;
use Modules\Icommerce\Events\OrderWasUpdated;

class UpdateSubOrdersStatus
{
  public function handle($event = null)
  {
    $data = $event->order;

    if (isset($data['order_id']) && isset($data['status'])) {
      $order = Order::where('id', $data['order_id'])->first();
    }

    //solo si es una orden padre se entra a buscar las hijas para actualizarlas todas
    if (isset($order->id) && (!isset($order->parent_id) || (empty($order->parent_id) && $order->children->isNotEmpty()))) {
      foreach ($order->children as $subOrder) {
        //Update Status Order Child
        $subOrder->update(['status_id' => $order->status_id]);
        \Log::info('Icommerce: Event|Handler|UpdateSubOrdersStatus|OrderChild|Id: ' . $subOrder->id);

        //Remember this event is used to add/update a credit
        event(new OrderWasUpdated($subOrder));

        //Add Status History to Order Child
        $orderStatusHistory = OrderStatusHistory::create([
          'order_id' => $subOrder->id,
          'notify' => 0,
          'status' => $order->status_id,
          'organization_id' => $subOrder->organization_id,
        ]);
      }
    }
  }
}