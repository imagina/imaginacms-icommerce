<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\User\Entities\Sentinel\User;


class ValidateQuantities
{
  public $productOptionValueRepository;
  public $productRepository;

  public function __construct()
  {
    $this->productOptionValueRepository = app('Modules\Icommerce\Repositories\ProductOptionValueRepository');
    $this->productRepository = app('Modules\Icommerce\Repositories\ProductRepository');
  }

  public function handle($event)
  {
    $productOptionValue = $event->entity;
    if (isset($productOptionValue->parent_prod_opt_val_id) && !is_null($productOptionValue->parent_prod_opt_val_id)) {
      $otherQuantitiesOptionValue = \DB::table('icommerce__product_option_value')
        ->where('parent_prod_opt_val_id', $productOptionValue->parent_prod_opt_val_id)
        ->where('subtract', 1)
        ->get()->pluck('quantity')->toArray();
      $parentQuantity = array_sum($otherQuantitiesOptionValue);
      $this->productOptionValueRepository->updateBy($productOptionValue->parent_prod_opt_val_id, ['quantity' => $parentQuantity]);
    } else {
      $otherQuantitiesProductOptionValue = \DB::table('icommerce__product_option_value')
        ->where('product_id', $productOptionValue->product_id)
        ->whereNull('parent_prod_opt_val_id')
        ->where('subtract', 1)
        ->get()->pluck('quantity')->toArray();
      $productQuantity = array_sum($otherQuantitiesProductOptionValue);
      $this->productRepository->updateBy($productOptionValue->product_id, ['quantity' => $productQuantity]);
    }
  }
}
