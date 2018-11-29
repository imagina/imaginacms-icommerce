<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
  protected $table = 'icommerce__cart_products';
  protected $fillable = [
    'cart_id',
    'product_id',
    'product_name',
    'quantity',
    'price',
    'options'
  
  ];
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
}
