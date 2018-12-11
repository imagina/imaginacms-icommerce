<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
  
  protected $table = 'icommerce__product_discounts';
  
  protected $fillable = [
    'product_id',
    'product_option_id',
    'product_option_value_id',
    'quantity',
    'priority',
    'discount',
    'criteria',
    'date_start',
    'date_end'
  ];
  
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
  
  public function productOptionValue()
  {
    return $this->belongsTo(ProductOptionValue::class);
  }
  public function productOption()
  {
    return $this->belongsTo(ProductOption::class);
  }
}
