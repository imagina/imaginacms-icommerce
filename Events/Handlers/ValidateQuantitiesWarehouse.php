<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\User\Entities\Sentinel\User;


class ValidateQuantitiesWarehouse
{
  public $productOptionValueRepository;
  public $productOptionValueWarehouseRepository;
  public $productWarehouseRepository;

  public function __construct()
  {
    $this->productOptionValueRepository = app('Modules\Icommerce\Repositories\ProductOptionValueRepository');
    $this->productOptionValueWarehouseRepository = app('Modules\Icommerce\Repositories\ProductOptionValueWarehouseRepository');
    $this->productWarehouseRepository = app('Modules\Icommerce\Repositories\productWarehouseRepository');
  }

  public function handle($event)
  {
    $productOptionValueWarehouse = $event->entity;
    $productOptionValue = \DB::table('icommerce__product_option_value')
      ->where('id', $productOptionValueWarehouse->product_option_value_id)
      ->first();
    if (isset($productOptionValue->id) && $productOptionValue->subtract) {

      $otherQuantitiesOptionValueWarehouse = \DB::table('icommerce__product_option_value_warehouse')
        ->where('product_option_value_id', $productOptionValueWarehouse->product_option_value_id)
        ->where('product_id', $productOptionValueWarehouse->product_id)
        ->get()->pluck('quantity')->toArray();

      $parentQuantityWarehouse = array_sum($otherQuantitiesOptionValueWarehouse);
      $this->productOptionValueRepository->updateBy($productOptionValueWarehouse->product_option_value_id,
        ['quantity' => $parentQuantityWarehouse]);

      if (isset($productOptionValue->parent_prod_opt_val_id) && !is_null($productOptionValue->parent_prod_opt_val_id)) {

        $otherProductOptionValueIds = \DB::table('icommerce__product_option_value')
          ->where('parent_prod_opt_val_id', $productOptionValue->parent_prod_opt_val_id)
          ->where('subtract', 1)
          ->get()->pluck('id')->toArray();

        $productOptionValueWarehouseQuantities = \DB::table('icommerce__product_option_value_warehouse')
          ->whereIn('id', $otherProductOptionValueIds)
          ->where('warehouse_id', $productOptionValueWarehouse->warehouse_id)
          ->get()->pluck('quantity')->toArray();

        $parentProductQuantityWarehouse = array_sum($productOptionValueWarehouseQuantities);
        $parentProductOptionValueWarehouse = \DB::table('icommerce__product_option_value_warehouse')
          ->where('product_option_value_id', $productOptionValue->parent_prod_opt_val_id)
          ->where('warehouse_id', $productOptionValueWarehouse->warehouse_id)
          ->where('product_id', $productOptionValue->product_id)
          ->first();

        if (isset($parentProductOptionValueWarehouse->id)) {
          $this->productOptionValueWarehouseRepository->updateBy($parentProductOptionValueWarehouse->id,
            ['quantity' => $parentProductQuantityWarehouse]);
        } else {
          $data = [
            'product_option_value_id' => $productOptionValue->parent_prod_opt_val_id,
            'warehouse_id' => $productOptionValueWarehouse->warehouse_id,
            'product_id' => $productOptionValue->product_id,
            'quantity' => $parentProductQuantityWarehouse
          ];
          $this->productOptionValueWarehouseRepository->create($data);
        }
      } else {

        $ProductOptionValueIds = \DB::table('icommerce__product_option_value')
          ->whereNull('parent_prod_opt_val_id')
          ->where('subtract', 1)
          ->where('product_id', $productOptionValue->product_id)
          ->get()->pluck('id')->toArray();

        $ProductOptionValueQuantities = \DB::table('icommerce__product_option_value_warehouse')
          ->whereIn('id', $ProductOptionValueIds)
          ->where('warehouse_id', $productOptionValueWarehouse->warehouse_id)
          ->get()->pluck('quantity')->toArray();

        $ProductQuantityWarehouse = array_sum($ProductOptionValueQuantities);
        if (isset($ProductOptionValue->id)) {

          $ProductWarehouse = \DB::table('icommerce__product_warehouse')
            ->where('product_id', $productOptionValue->product_id)
            ->where('warehouse_id', $productOptionValueWarehouse->warehouse_id)
            ->first();

          $this->productWarehouseRepository->updateBy($ProductWarehouse->id, ['quantity' => $ProductQuantityWarehouse]);

        } else {

          $data = [
            'warehouse_id' => $productOptionValueWarehouse->warehouse_id,
            'product_id' => $productOptionValue->product_id,
            'quantity' => $ProductQuantityWarehouse
          ];
          $this->productWarehouseRepository->create($data);

        }
      }
    }
  }
}
