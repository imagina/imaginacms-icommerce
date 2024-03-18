<?php

namespace Modules\Icommerce\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class ProductWarehouse extends CrudModel
{

  protected $table = 'icommerce__product_warehouse';
  public $transformer = 'Modules\Icommerce\Transformers\ProductWarehouseTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ProductWarehouseRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateProductWarehouseRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateProductWarehouseRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  
  protected $fillable = [
    'product_id',
    'warehouse_id',
    'quantity'
  ];

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function warehouse()
  {
    return $this->belongsTo(Warehouse::class);
  }
  
}
