<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;

class OrderItem extends CrudModel
{

  protected $table = 'icommerce__order_item';
  public $transformer = 'Modules\Icommerce\Transformers\OrderItemTransformer';
  public $repository = 'Modules\Icommerce\Repositories\OrderItemRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateOrderItemRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateOrderItemRequest',
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
    'product_id',
    'item_type_id',
    'title',
    'reference',
    'quantity',
    'price',
    'total',
    'tax',
    'reward',
    'options',
    'entity_type',
    'entity_id',
    'organization_id',
    'discount'
  ];


  protected $casts = [
    'options' => 'array',
    'discount' => 'array',
  ];

  public function entity()
  {
    return $this->belongsTo($this->entity_type, 'entity_id');
  }

  public function orderOption()
  {
    return $this->hasMany(OrderOption::class);
  }

  public function type()
  {
    return $this->belongsTo(ItemType::class);
  }

  public function order()
  {
    return $this->belongsTo(Order::class, 'order_id');
  }

  public function product()
  {
    return $this->belongsTo(Product::class, 'product_id');
  }

  public function getOptionsAttribute($value)
  {

    return json_decode($value);

  }

  public function setOptionsAttribute($value)
  {

    $this->attributes['options'] = json_encode($value);

  }

  public function getDiscountAttribute($value)
  {

    return json_decode($value);

  }

  public function setDiscountAttribute($value)
  {

    $this->attributes['discount'] = json_encode($value);

  }

  public function getProductOptionsLabelAttribute()
  {
    return $this->orderOption()->get()->map(function ($item) {
      return $item->option_description . ": " . $item->option_value_description;
    })->implode(', ');
  }


}
