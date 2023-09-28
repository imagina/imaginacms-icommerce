<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;

class OrderItem extends Model
{
    use AuditTrait;

    protected $table = 'icommerce__order_item';

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
        'discount',
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
