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
    'product_name',
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

  public function product()
  {
    return $this->belongsTo(Product::class);
  }

    public function cartproductoption()
    {
        return $this->belongsToMany(ProductOption::class, 'icommerce__cart_product_options')
            ->withPivot(
                'id',
                'cart_product_id',
                'product_option_id',
                'product_option_value_id'
            )->withTimestamps();

    }

    public function getSubTotalAttribute()
    {
        $subtotal = $this->price * $this->quantity;
        $subtotalOpciones = 0;
      
        if(isset($this->cartproductoption) && count($this->cartproductoption)>0){

          foreach($this->cartproductoption as $productOption){
            $price = 0;
            if($productOption->pivot->product_option_value_id!=null){
              $productOptionValue = $productOption->productOptionValues->find($productOption->pivot->product_option_value_id);
              $price = $productOptionValue->price * $this->quantity;
              $subtotalOpciones += $price;
            }
          }

        }


        return $subtotal + $subtotalOpciones;
    }

    public function getNameproductAttribute()
    {
        return Product::find($this->product_id)->name;
    }

}
