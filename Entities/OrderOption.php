<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class OrderOption extends CrudModel
{

  protected $table = 'icommerce__order_options';
  public $transformer = 'Modules\Icommerce\Transformers\OrderOptionTransformer';
  public $repository = 'Modules\Icommerce\Repositories\OrderOptionRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateOrderOptionRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateOrderOptionRequest',
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
    'order_id',
    'order_item_id',
    'option_description',
    'option_value_description',
    'price',
    'price_prefix',
    'points',
    'points_prefix',
    'weight',
    'weight_prefix',
    'value',
    'required'
  ];

  public function order()
  {
    return $this->belongsTo(Order::class);
  }

  public function orderItem()
  {
    return $this->belongsTo(OrderItem::class);
  }

  public function productOption()
  {
    return $this->belongsTo(ProductOption::class);
  }

  public function productOptionValue()
  {
    return $this->belongsTo(ProductOptionValue::class);
  }
}