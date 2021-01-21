<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
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
    'weight_prefix',
    'stock_status'
  ];

  // OK YA PROBADAS
  public function cartproductoptions()
  {
    return $this->hasMany(CartProductOption::class);
  }

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

  public function parentOptionValue()
  {
    return $this->belongsTo(OptionValue::class, 'parent_option_value_id');
  }

  public function orderOption()
  {
    return $this->hasMany(OrderOption::class);
  }

  public function parentProductOptionValue()
  {
    return $this->belongsTo($this, 'parent_option_value_id');
  }

  public function childrenProductOptionValue()
  {
    return $this->hasMany($this,  'parent_option_value_id', 'id');
  }

  public function updateStockByChildren()
  {
    $stock = 0;
    if ($this->subtract) {
      foreach ($this->childrenProductOptionValue as $key => $children) {
        if ($children->subtract && $children->stock_status == 1) {
          $stock += $children->quantity;
        }
      }
      $this->update(["quantity" => $stock]);
      if ($stock == 0) {
        $this->update(["stock_status" => 0]);
      }elseif ($this->stock_status == 0 && $this->childrenProductOptionValue()->where("stock_status",1)->get()->isNotEmpty()) {
        $this->update(["stock_status" => 1]);
      }
      if ($this->parentProductOptionValue) {
        $this->parentProductOptionValue->updateStockByChildren();
      }
      return $stock;

    }
    return $this->quantity;
  }
}
