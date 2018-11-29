<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductOptionValue extends Model
{
  
  protected $table = 'icommerce__product_option_value';
  
  protected $fillable = [
    'product_option_id',
    'product_id',
    'option_id',
    'option_value_id',
    'parent_option_value_id',
    'quantity',
    'subtract',
    'price',
    'price_prefix',
    'points',
    'points_prefix',
    'weight',
    'weight_prefix'
  ];
  
  //************* OJO DUDAS PROBAR ********************
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
  
  //************* OJO DUDAS PROBAR ********************
  public function productOption()
  {
    return $this->belongsTo(ProductOption::class);
  }
  
  //************* OJO DUDAS PROBAR ********************
  public function option()
  {
    return $this->belongsTo(Option::class);
  }
  
  //************* OJO DUDAS PROBAR ********************
  public function optionValue()
  {
    return $this->belongsTo(OptionValue::class);
  }
  
  public function orderOption()
  {
    return $this->hasMany(OrderOption::class);
  }
  
}
