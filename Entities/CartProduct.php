<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Icommerce\Entities\Product;

class CartProduct extends Model
{
  protected $table = 'icommerce__cart_product';

  protected $fillable = [
    'cart_id',
    'product_id',
    'warehouse_id',
    'quantity',
    'is_call',
    'organization_id',
    'options'

  ];


  protected $casts = [
    'options' => 'array'
  ];

  public function cart()
  {
    return $this->belongsTo(Cart::class);
  }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

  public function warehouse()
  {
    return $this->belongsTo(Warehouse::class);
  }

  public function productOptionValues()
  {
    return $this->belongsToMany(ProductOptionValue::class, 'icommerce__cart_product_options')->withTimestamps();

  }
  
  public function dynamicOptions()
  {
    return $this->belongsToMany(Option::class, 'icommerce__cart_product_options')
    ->withPivot('cart_product_id', 'product_option_value_id', 'option_id', 'value')
    ->withTimestamps();
  }

  public function setOptionsAttribute($value)
  {
    $this->attributes['options'] = json_encode($value);
  }


  public function getOptionsAttribute($value)
  {
    return json_decode($value);
  }


  public function getTotalAttribute()
  {
    if (!$this->product->is_call) {
      $priceBase = $this->product->discount->price ?? $this->product->price;
      $subtotal = floatval($priceBase) * intval($this->quantity);
      $totalOptions = 0;

      foreach ($this->productOptionValues as $productOptionValue) {
        $price = 0;
        $price = floatval($productOptionValue->price) * intval($this->quantity);

        $productOptionValue->price_prefix == '+' ? $totalOptions += $price : $totalOptions -= $price;

      }

      return $subtotal + $totalOptions;
    } else {
      return 0;
    }

  }

  public function getPriceUnitAttribute()
  {
    $priceBase = $this->product->discount->price ?? $this->product->price;
    $subtotal = floatval($priceBase);
    $totalOptions = 0;

    foreach ($this->productOptionValues as $productOptionValue) {
      $price = 0;
      $price = floatval($productOptionValue->price);

      if ($productOptionValue->price_prefix == '+')
        $totalOptions += $price;
      else
        $totalOptions -= $price;
    }

    return $subtotal + $totalOptions;
  }

  public function getNameProductAttribute()
  {
    return Product::find($this->product_id)->name;
  }

}
