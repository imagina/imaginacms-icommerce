<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderOption extends Model
{
    protected $table = 'icommerce__order_options';

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
        'required',
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
