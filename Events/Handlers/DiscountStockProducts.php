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

        //Order is Proccesed and no es una sub orden entonces si descuente de inventario, las subordenes no vuelven a descontar los productos
        if ($order->status_id == 13 && ! $order->parent_id) {
            foreach ($order->orderItems as $item) {
                $productQuantity = $item->product->quantity;
                $productQuantity -= $item->quantity;

                if ($productQuantity < 0) {
                    $productQuantity = 0;
                }

                $params = ['quantity' => $productQuantity];
                $item->product->update($params);
            }
        }// end If
    }// If handle
}
