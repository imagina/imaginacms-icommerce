<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class OrderOption extends Model
{
  
  protected $table = 'icommerce__order_options';

  protected $fillable = [
    'order_id',
    'order_product_id',
    'parent_value',
    'price',
    'weight',
    'option_value',
    'value',
    'required'
  ];

  public function order()
  {
    return $this->belongsTo(Order::class);
  }
  
  public function orderProduct()
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
