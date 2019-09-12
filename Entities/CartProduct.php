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

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

    public function productOptionValues()
    {
        return $this->belongsToMany(ProductOptionValue::class, 'icommerce__cart_product_options')->withTimestamps();

    }

    public function getTotalAttribute()
    {
        $subtotal = floatval($this->product->price) * intval($this->quantity);
        $totalOptions = 0;

        foreach($this->productOptionValues as $productOptionValue){
          $price = 0;
          $price = floatval($productOptionValue->price) * intval($this->quantity);

          if($productOptionValue->price_prefix == '+')
            $totalOptions += $price;
          else
            $totalOptions -= $price;
        }

        return $subtotal + $totalOptions;
    }

    public function getPriceUnitAttribute()
    {
        $subtotal = floatval($this->product->price);
        $totalOptions = 0;

        foreach($this->productOptionValues as $productOptionValue){
          $price = 0;
          $price = floatval($productOptionValue->price);

          if($productOptionValue->price_prefix == '+')
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
