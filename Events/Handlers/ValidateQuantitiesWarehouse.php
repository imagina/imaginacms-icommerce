<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\User\Entities\Sentinel\User;


class ValidateQuantitiesWarehouse
{
  public $productOptionValueRepository;
  public $productOptionValueWarehouseRepository;
  public $productWarehouseRepository;

  //handler cuya funcionalidad busca en cantidades en las bodegas y asigna estas cantidades a las tablas sin warehouse
  public function __construct()
  {
    $this->productOptionValueRepository = app('Modules\Icommerce\Repositories\ProductOptionValueRepository');
    $this->productOptionValueWarehouseRepository = app('Modules\Icommerce\Repositories\ProductOptionValueWarehouseRepository');
    $this->productWarehouseRepository = app('Modules\Icommerce\Repositories\ProductWarehouseRepository');
  }

  public function handle($event)
  {
    $productOptionValueWarehouse = $event->entity;

    //se busca en la table product option value con el id de la opcion que ese esta actualizando
    $productOptionValue = \DB::table('icommerce__product_option_value')
      ->where('id', $productOptionValueWarehouse->product_option_value_id)
      ->first();
    if (isset($productOptionValue->id) && $productOptionValue->subtract) {

      //busca todas las opciones de producto sin importar el warehouse y se suman sus cantidades para
      // actualizar el quantity de la opción
      $otherQuantitiesOptionValueWarehouse = \DB::table('icommerce__product_option_value_warehouse')
        ->where('product_option_value_id', $productOptionValueWarehouse->product_option_value_id)
        ->where('product_id', $productOptionValueWarehouse->product_id)
        ->get()->pluck('quantity')->toArray();

      // se suman todos los quantities encontrados con el query anterior
      $parentQuantityWarehouse = array_sum($otherQuantitiesOptionValueWarehouse);

      //se asigna el valor de la suma de todas las bodegas a la opcion principal
      $this->productOptionValueRepository->updateBy($productOptionValueWarehouse->product_option_value_id,
        ['quantity' => $parentQuantityWarehouse]);

      if (isset($productOptionValue->parent_prod_opt_val_id) && !is_null($productOptionValue->parent_prod_opt_val_id)) {

        //se obtienen los id de las opciones hermanas
        $otherProductOptionValueIds = \DB::table('icommerce__product_option_value')
          ->where('parent_prod_opt_val_id', $productOptionValue->parent_prod_opt_val_id)
          ->where('subtract', 1)
          ->get()->pluck('id')->toArray();

        //se buscan con los ids anteriores y se totaliza la cantidad
        $productOptionValueWarehouseQuantities = \DB::table('icommerce__product_option_value_warehouse')
          ->whereIn('id', $otherProductOptionValueIds)
          ->where('warehouse_id', $productOptionValueWarehouse->warehouse_id)
          ->get()->pluck('quantity')->toArray();

        // se suman todos los quantities encontrados con el query anterior
        $parentProductQuantityWarehouse = array_sum($productOptionValueWarehouseQuantities);
        $parentProductOptionValueWarehouse = \DB::table('icommerce__product_option_value_warehouse')
          ->where('product_option_value_id', $productOptionValue->parent_prod_opt_val_id)
          ->where('warehouse_id', $productOptionValueWarehouse->warehouse_id)
          ->where('product_id', $productOptionValue->product_id)
          ->first();

        // se busca la opcion si se encuentra se actualiza sino se crea un nuevo registro con los datos obtenidos
        if (isset($parentProductOptionValueWarehouse->id)) {
          $this->productOptionValueWarehouseRepository->updateBy($parentProductOptionValueWarehouse->id,
            ['quantity' => $parentProductQuantityWarehouse]);
        } else {

          //si el option no existe se crea la data y se envia al repo para su creacion
          $data = [
            'product_option_value_id' => $productOptionValue->parent_prod_opt_val_id,
            'warehouse_id' => $productOptionValueWarehouse->warehouse_id,
            'product_id' => $productOptionValue->product_id,
            'quantity' => $parentProductQuantityWarehouse
          ];
          $this->productOptionValueWarehouseRepository->create($data);
        }
      } else {

        // si no tiene padre se busca las opciones hermanas de primer nivel buscando sus Ids
        $productOptionValueIds = \DB::table('icommerce__product_option_value')
          ->whereNull('parent_prod_opt_val_id')
          ->where('subtract', 1)
          ->where('product_id', $productOptionValue->product_id)
          ->get()->pluck('id')->toArray();

        // se totaliza las cantidades para este producto
        $productOptionValueQuantities = \DB::table('icommerce__product_option_value_warehouse')
          ->whereIn('product_option_value_id', $productOptionValueIds)
          ->where('warehouse_id', $productOptionValueWarehouse->warehouse_id)
          ->where('product_id', $productOptionValue->product_id)
          ->get()->pluck('quantity')->toArray();

        // se suman todos los quantities encontrados con el query anterior
        $productQuantityWarehouse = array_sum($productOptionValueQuantities);
        $productWarehouse = \DB::table('icommerce__product_warehouse')
          ->where('product_id', $productOptionValue->product_id)
          ->where('warehouse_id', $productOptionValueWarehouse->warehouse_id)
          ->first();

        //se crea o se actualiza con los datos anteriores para totalizar las opciones en cada warehouse
        if (isset($productWarehouse->id)) {

          $this->productWarehouseRepository->updateBy($productWarehouse->id, ['quantity' => $productQuantityWarehouse]);

        } else {

          //si el option no existe se crea la data y se envia al repo para su creacion
          $data = [
            'warehouse_id' => $productOptionValueWarehouse->warehouse_id,
            'product_id' => $productOptionValue->product_id,
            'quantity' => $productQuantityWarehouse
          ];
          $this->productWarehouseRepository->create($data);

        }
      }
    }
  }
}
