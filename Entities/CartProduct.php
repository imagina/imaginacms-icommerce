<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\Product;

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

    public function cartproductoption()
    {
        return $this->hasMany(CartProductOption::class);
    }

    public function getSubTotalAttribute()
    {
        $subtotal = $this->price * $this->quantity;
        $subtotalOpciones = 0;
        return $subtotal + $subtotalOpciones;
    }

    public function getNameproductAttribute()
    {
        return Product::find($this->product_id)->name;
    }

}
