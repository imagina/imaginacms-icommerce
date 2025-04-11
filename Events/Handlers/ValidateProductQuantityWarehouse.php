<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\User\Entities\Sentinel\User;


class ValidateProductQuantityWarehouse
{
  public $productRepository;

  //handler utilizado para totalizar la cantidad del producto sin importar su bodega
  public function __construct()
  {
    $this->productRepository = app('Modules\Icommerce\Repositories\ProductRepository');
  }

  public function handle($event)
  {
    //si se crea un producto en una bodega se debe actualizar el producto global
    $productWarehouse = $event->entity;
    //se busca el producto que se actualiza o se crea en todas las bodegas tomando su cantidades en un array
    $productWarehouseQuantities = \DB::table('icommerce__product_warehouse')
      ->where('product_id', $productWarehouse->product_id)
      ->get()->pluck('quantity')->toArray();

    //se totalizan las cantidades encontradas en el query anterior
    $ProductQuantityWarehouse = array_sum($productWarehouseQuantities);
    if ($ProductQuantityWarehouse > 0) {
      //se activa el stock y se actualiza su cantidad ya que se encontron cantidades mayor a cero
      $this->productRepository->updateBy($productWarehouse->product_id, ['quantity' => $ProductQuantityWarehouse,  "stock_status" => 1]);
    } else {
      //se desactiva su stock y su cantidad se vuelve cero apara evitar inventarios con numeros negativos
      $this->productRepository->updateBy($productWarehouse->product_id, ['quantity' => 0,  "stock_status" => 0]);
    }
  }
}
