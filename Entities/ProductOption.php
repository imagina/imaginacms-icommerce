<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{

  protected $table = 'icommerce__product_option';

  protected $with = ["productOptionValues"];
  
  protected $fillable = [
    'product_id',
    'option_id',
    'parent_id',
    'parent_option_value_id',
    'value',
    'required',
    'sort_order'
  ];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    public function parent()
    {
        return $this->belongsTo(Option::class, 'parent_id');
    }

  public function product()
  {
    return $this->belongsTo(Product::class);
  }


  public function productOptionValues()
  {
    return $this->hasMany(ProductOptionValue::class);
  }

  public function orderOptions()
  {
    return $this->hasMany(OrderOption::class);
  }

}
