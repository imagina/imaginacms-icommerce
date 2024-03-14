<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\User\Entities\Sentinel\User;


class ValidateQuantities
{
  public $productOptionValueRepository;
  public $productRepository;

  //handler para totalizar las opciones de producto y asignarlo al producto al quantity del producto padre
  public function __construct()
  {
    $this->productOptionValueRepository = app('Modules\Icommerce\Repositories\ProductOptionValueRepository');
    $this->productRepository = app('Modules\Icommerce\Repositories\ProductRepository');
  }

  public function handle($event)
  {

    $productOptionValue = $event->entity;
    if (isset($productOptionValue->parent_prod_opt_val_id) && !is_null($productOptionValue->parent_prod_opt_val_id)) {

      //si la opcion tiene un padre se busca todas las hermanas y se sacan sus cantidades en un array
      $otherQuantitiesOptionValue = \DB::table('icommerce__product_option_value')
        ->where('parent_prod_opt_val_id', $productOptionValue->parent_prod_opt_val_id)
        ->where('subtract', 1)
        ->get()->pluck('quantity')->toArray();

      //se totaliza las cantidades conseguidas
      $parentQuantity = array_sum($otherQuantitiesOptionValue);

      //se asigna el total de las cantidades encontradas
      $this->productOptionValueRepository->updateBy($productOptionValue->parent_prod_opt_val_id, ['quantity' => $parentQuantity]);
    } else {

      //si no tiene padre se busca las opciones sin padre y se toman sus cantidades en un array
      $otherQuantitiesProductOptionValue = \DB::table('icommerce__product_option_value')
        ->where('product_id', $productOptionValue->product_id)
        ->whereNull('parent_prod_opt_val_id')
        ->where('subtract', 1)
        ->get()->pluck('quantity')->toArray();

      //se totaliza las cantidades obtenidas en el query anterior
      $productQuantity = array_sum($otherQuantitiesProductOptionValue);
      if ($productQuantity > 0) {

        //si el total encontrado es mayor a 0 se actualiza la canidad del producto principal y se activa su stock
        $this->productRepository->updateBy($productOptionValue->product_id, ['quantity' => $productQuantity, "stock_status" => 1]);
      } else {

        //si no es mayor a 0 se actualiza la canidad del producto principal a cero y se dasactica su stock
        $this->productRepository->updateBy($productOptionValue->product_id, ['quantity' => 0, "stock_status" => 0]);
      }
    }
  }
}
