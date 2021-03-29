<?php

namespace Modules\Icommerce\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Icommerce\Entities\Order;

class OrderReturnStock
{

    /**
     * @var Mailer
     */

    public function __construct()
    {
    }

    public function handle($event)
    {
        try {
            $data = $event->order;
            if (isset($data['order_id']) && isset($data['status'])) {
                $order = Order::where('id', $data['order_id'])->first();
                $action = null;
                //Verifica si la orden existe, y si el estatus a setear devuelve el stock
                if ($order && !$order->returned_stock && isset(config('asgard.icommerce.config.orderStatuses')[$data['status']]) && isset(config('asgard.icommerce.config.orderStatuses')[$data['status']]["returnStock"]) && config('asgard.icommerce.config.orderStatuses')[$data['status']]["returnStock"] === true) {
                    //recorre los items de la orden
                    $action = 1;
                    //stock devuelto en orden
                    $order->update(["returned_stock" => 1]);
                } elseif ($order && $order->returned_stock == 1 &&$data["status"] == 1) {
                    $action = 2;
                    //stock restado en orden
                    $order->update(["returned_stock" => 0]);
                }
                if ($action !== null) {
                    foreach ($order->orderItems as $key => $item) {
                        if ($item->orderOption->isNotEmpty()) {
                            //si el item posee opciones de productos
                            foreach ($item->orderOption as $k => $orderOption) {
                                foreach ($item->product->productOptions->where("description", $orderOption->option_description) as $option) {
                                    //Busca el ID de OptionValue configurado al producto
                                    $id           = $option->optionValues->where("description", $orderOption->option_value_description)->first()->id;
                                    $optionValues = $item->product->optionValues->where("option_value_id", $id)->first();
                                    //Si la opcion de producto existe y descuenta de stock, suma el stock
                                    if ($optionValues && $optionValues->subtract) {
                                        if ($action == 1) {
                                            //Devolver el Stock
                                            $optionValues->quantity += $item->quantity;
                                        } else {
                                            //Restar del Stock
                                            $optionValues->quantity -= $item->quantity;
                                        }
                                        $stock_status = 1;
                                        if ($optionValues->quantity == 0) {
                                            $stock_status = 0;
                                        }
                                        //actualiza el nuevo stock
                                        $optionValues->update(["quantity" => $optionValues->quantity, "stock_status" => $stock_status]);
                                        //Buscar el padre de la opcion seleccionada, si no tiene padre, ella es el padre
                                        if ($optionValues->parentProductOptionValue) {
                                            $father = $optionValues->parentProductOptionValue;
                                        } else {
                                            $father = $optionValues;
                                        }
                                        if ($father->childrenProductOptionValue->isNotEmpty()) {
                                            //Verificacion y posible actualizacion de status y stock de padre en base a los hijos
                                            $stock = $father->updateStockByChildren();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Log::error("Error | OrderReturnStock Event: " . $e->getMessage() . "\n" . $e->getFile() . "\n" . $e->getLine());
        }

    }

}
