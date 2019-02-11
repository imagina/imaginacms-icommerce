<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
  protected $table = 'icommerce__cart_product';
  protected $fillable = [
    'cart_id',
    'product_id',
    'quantity',
    'price',
    'options'

  ];
  protected $fakeColumns = ['options'];

  protected $casts = [
    'options' => 'array'
  ];

  public function cart()
  {
    return $this->belongsTo(Cart::class);
  }

    public function options()
    {
        return $this->belongsToMany(ProductOption::class, 'icommerce__cart_product_options');
    }

}
