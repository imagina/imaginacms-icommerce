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
    'product_option_id',
    'product_option_value_id',
    'name',
    'value',
    'type',
    'options'
  ];
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  public function order()
  {
    return $this->belongsTo(Order::class);
  }
  
  public function order_product()
  {
    return $this->belongsTo(OrderProduct::class);
  }
  
  public function product_option()
  {
    return $this->belongsTo(ProductOption::class);
  }
  
  public function product_option_value()
  {
    return $this->belongsTo(ProductOptionValue::class);
  }
}
