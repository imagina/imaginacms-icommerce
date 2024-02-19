<?php

namespace Modules\Icommerce\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class ProductOptionValueWarehouse extends CrudModel
{

  protected $table = 'icommerce__product_option_value_warehouse';
  public $transformer = 'Modules\Icommerce\Transformers\ProductOptionValueWarehouseTransformer';
  public $repository = 'Modules\Icommerce\Repositories\ProductOptionValueWarehouseRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateProductOptionValueWarehouseRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateProductOptionValueWarehouseRequest',
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
    'product_option_value_id',
    'warehouse_id',
    'quantity',
    'product_id',
    'option_id',
    'option_value_id'
  ];

  public function productOptionValue()
  {
    return $this->belongsTo(ProductOptionValue::class);
  }

  public function warehouse()
  {
    return $this->belongsTo(Warehouse::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function option()
  {
    return $this->belongsTo(Option::class);
  }

  public function optionValue()
  {
    return $this->belongsTo(OptionValue::class);
  }

}
