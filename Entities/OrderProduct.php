<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
  
  protected $table = 'icommerce__order_product';

  protected $fillable = [
    'order_id',
    'product_id',
    'title',
    'reference',
    'quantity',
    'price',
    'total',
    'tax',
    'reward',
    'options'
  ];
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  public function order_option(){
    return $this->hasMany(Order_Option::class);
  }
}
