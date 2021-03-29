<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\Icommerce\Emails\LowStock;
use Modules\Icommerce\Entities\Product;
//Support
use Modules\Icommerce\Support\OrderOption as orderOptionSupport;
use Modules\Icommerce\Events\ProductLowStock;
use Modules\Icommerce\Events\ProductOptionLowStock;
use Modules\Icommerce\Events\ProductOptionSoldOut;
use Modules\Icommerce\Events\ProductSoldOut;

class SaveOrderItems
{
    private $emails;
    public function __construct()
    {
        $this->emails = explode(',', setting('icommerce::form-emails'));
    }
    
    public function handle($event)
    {
        $productMinimumQuantityToNotify = 0;
        if (setting('icommerce::productMinimumQuantityToNotify')) {
            $productMinimumQuantityToNotify = setting('icommerce::productMinimumQuantityToNotify');
        }
        $order = $event->order;
        $items = $event->items;
        foreach ($items as $item) {
          $cartProductOptionsValues = $item["productOptionValues"];
          unset($item["productOptionValues"]);

            // Create Order Items
            $orderItem = $order->orderItems()->create($item);
            $product   = Product::find($item["product_id"]);
            if (isset($product->id) && $product->subtract) {
                $product->quantity = $product->quantity - $item["quantity"];
                $product->quantity < 0 ? $product->quantity = 0 : false;
               
                //si el producto se agota y está como substraible de l stock, automáticamente pasarlo a producto agotado/
                if ($product->quantity == 0 && $product->subtract) {
                    $product->stock_status = 0;
                }
                
                //Notificaciones al correo de producto agotado o de
                if ($product->quantity <= $productMinimumQuantityToNotify) {
                    if ($product->stock_status == 0 || $product->quantity == 0) {
                        event(new ProductSoldOut($this->emails,$product));
                    } else {
                        event(new ProductLowStock($this->emails,$product));
                    }
                }
                $product->save();
            }
            
            if ($cartProductOptionsValues != null) {
                foreach ($cartProductOptionsValues as $productOptionValue) {
                    $quantity_ = $stock = 0;
                    // Fix Data OrderOption
                    $supportOrderOption = new orderOptionSupport();
                    $dataOrderOption    = $supportOrderOption->fixData($order->id, $orderItem->id, $productOptionValue);
                    $logvar             = json_encode($dataOrderOption);
                    // Create Order Option
                    $order->orderOption()->create($dataOrderOption);
                    
                    
                    if ($productOptionValue->subtract) {
                        //Restar cantidad comprada a la opcion seleccionada
                        $productOptionValue->quantity = $productOptionValue->quantity - $item["quantity"];
                        $productOptionValue->quantity < 0 ? $productOptionValue->quantity = 0 : false;
                        $stock_status = $productOptionValue->stock_status;
                        if ($productOptionValue->quantity == 0) {
                            $stock_status = 0;
                        }
                        $productOptionValue->update(["quantity" => $productOptionValue->quantity, "stock_status" => $stock_status]);

                        //Verifica si la opcion es un hijo
                        if ($productOptionValue->parentProductOptionValue) {
                            $father = $productOptionValue->parentProductOptionValue;
                            //Segunda Verificacion, al ser padre verifica que tenga hijos (no es totalmente necesario)
                            if ($father->childrenProductOptionValue->isNotEmpty()) {
                                //Verificacion y posible actualizacion de status y stock de padre
                                $stock = $father->updateStockByChildren();
                            }
                        }

                        if ($productOptionValue->quantity <= $productMinimumQuantityToNotify) {
                            if ($productOptionValue->stock_status == 0 || $productOptionValue->quantity == 0) {
                                event(new ProductOptionSoldOut($this->emails,$product,$productOptionValue));
                            } else {
                                event(new ProductOptionLowStock($this->emails,$product,$productOptionValue));
                            }
                        }
                    }
                }
            }
        } // End Foreach
    } // If handle
}
