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
  private $log = "Icommerce: Events|Handlers|SaveOrderItems";
  public $warehouseEnable;
  public $productOptionValueWarehouseRepository;
  public $productWarehouseRepository;
  public $productRepository;

  public function __construct()
  {
    $this->emails = explode(',', setting('icommerce::form-emails'));
    $this->warehouseEnable = setting('icommerce::warehouseFunctionality', null, false);
    $this->productOptionValueWarehouseRepository = app('Modules\Icommerce\Repositories\ProductOptionValueWarehouseRepository');
    $this->productWarehouseRepository = app('Modules\Icommerce\Repositories\ProductWarehouseRepository');
    $this->productRepository = app('Modules\Icommerce\Repositories\ProductRepository');
  }

  public function handle($event)
  {
    $productMinimumQuantityToNotify = 0;
    if (setting('icommerce::productMinimumQuantityToNotify')) {
      $productMinimumQuantityToNotify = setting('icommerce::productMinimumQuantityToNotify');
    }
    $order = $event->order;
    $items = $event->items; //Items From Order (Products)

    foreach ($items as $item) {

      if (isset($order->organization_id) && !empty($order->organization_id) && $item["organization_id"] != $order->organization_id) {
        continue;
      }

      $cartProductOptionsValues = $item["productOptionValues"];
      unset($item["productOptionValues"]);

      //Case No Dynamics
      $cartProductOptions = $item["productOptions"];
      unset($item["productOptions"]);


      // Create Order Items
      $orderItem = $order->orderItems()->create($item);
      $product = Product::find($item["product_id"]);

      //if no es una sub orden entonces si descuente de inventario, las subordenes no vuelven a descontar los productos
      if (!$order->parent_id) {
        if (isset($product->id) && $product->subtract) {
          // restar cantidades en los warehouses solo si dicha función está activa
          if ($this->warehouseEnable) {
            $warehouseProduct = \DB::table('icommerce__product_warehouse')
              ->where('warehouse_id', $order->warehouse_id)
              ->where('product_id', $product->id)
              ->first();
            $warehouseProduct->quantity = $warehouseProduct->quantity - $item["quantity"];
            $this->productWarehouseRepository->updateBy($warehouseProduct->id, ['quantity' => $warehouseProduct->quantity]);
          }
          $product->quantity = $product->quantity - $item["quantity"];
          $product->quantity < 0 ? $product->quantity = 0 : false;

          //si el producto se agota y está como substraible de l stock, automáticamente pasarlo a producto agotado/
          if ($product->quantity == 0 && $product->subtract) {
            $product->stock_status = 0;
          }

          //Notificaciones al correo de producto agotado o de
          if ($product->quantity <= $productMinimumQuantityToNotify) {
            if ($product->stock_status == 0 || $product->quantity == 0) {
              event(new ProductSoldOut($this->emails, $product));
            } else {
              event(new ProductLowStock($this->emails, $product));
            }
          }
//          $product->save();
          $this->productRepository->updateBy($product->id, ['quantity' => $product->quantity, "stock_status" => $product->stock_status]);
        }

        $supportOrderOption = new orderOptionSupport();

        if ($cartProductOptionsValues != null) {
          foreach ($cartProductOptionsValues as $productOptionValue) {
            $quantity_ = $stock = 0;
            // Fix Data OrderOption
            $dataOrderOption = $supportOrderOption->fixData($order->id, $orderItem, $productOptionValue);
            $logvar = json_encode($dataOrderOption);
            // Create Order Option
            $order->orderOption()->create($dataOrderOption);

            if ($productOptionValue->subtract) {
              // restar cantidades en los warehouses solo si dicha función está activa
              if ($this->warehouseEnable) {
                $warehouseProductOptionValueWarehouse = \DB::table('icommerce__product_option_value_warehouse')
                  ->where('warehouse_id', $order->warehouse_id)
                  ->where('product_option_value_id', $productOptionValue->id)
                  ->first();
                $warehouseProductOptionValueWarehouse->quantity = $warehouseProductOptionValueWarehouse->quantity - $item["quantity"];
                $this->productOptionValueWarehouseRepository->updateBy($warehouseProductOptionValueWarehouse->id, ['quantity' => $warehouseProductOptionValueWarehouse->quantity]);
              }
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
                  event(new ProductOptionSoldOut($this->emails, $product, $productOptionValue));
                } else {
                  event(new ProductOptionLowStock($this->emails, $product, $productOptionValue));
                }
              }
            }


          }
        }

        //Case No Dynamics
        if ($cartProductOptions != null) {
          //\Log::info($this->log."CartProductOptions|FixData|");
          foreach ($cartProductOptions as $option) {
            // Fix Data OrderOption
            $dataOrderOption = $supportOrderOption->fixData($order->id, $orderItem, null, $option);

            // Create Order Option
            $order->orderOption()->create($dataOrderOption);

          }
        }

      }

    } // End Foreach
  } // If handle
}
