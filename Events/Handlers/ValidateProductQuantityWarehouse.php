<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\User\Entities\Sentinel\User;


class ValidateProductQuantityWarehouse
{
  public $productRepository;

  public function __construct()
  {
    $this->productRepository = app('Modules\Icommerce\Repositories\productRepository');
  }

  public function handle($event)
  {
    $productWarehouse = $event->entity;
    $productWarehouseQuantities = \DB::table('icommerce__product_warehouse')
      ->where('product_id', $productWarehouse->product_id)
      ->get()->pluck('quantity')->toArray();
    $ProductQuantityWarehouse = array_sum($productWarehouseQuantities);
    if ($ProductQuantityWarehouse > 0) {
      $this->productRepository->updateBy($productWarehouse->product_id, ['quantity' => $ProductQuantityWarehouse,  "stock_status" => 1]);
    } else {
      $this->productRepository->updateBy($productWarehouse->product_id, ['quantity' => 0,  "stock_status" => 0]);
    }
  }
}
