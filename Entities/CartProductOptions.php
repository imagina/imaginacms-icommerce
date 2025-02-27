<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CartProductOptions extends Model
{
  protected $table = 'icommerce__cart_product_options';
  protected $fillable = [
    'cart_product_id',
    'product_option_value_id',
    'option_id',
    'value'
  ];

  public function cartProduct()
  {
    return $this->belongsTo(CartProduct::class, 'cart_product_id');
  }

  public function productOptionValue()
  {
    return $this->belongsTo(ProductOptionValue::class, 'product_option_value_id');
  }

  public function option()
  {
    return $this->belongsTo(Option::class , 'option_id');
  }
  public function dynamicProductOptionValue()
  {
    return $this->belongsTo(ProductOptionValue::class , 'value');
  }

}
