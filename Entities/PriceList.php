<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class PriceList extends Model
{
  use Translatable;
  
  protected $table = 'icommerce__price_lists';
  public $translatedAttributes = [
    'name'
  ];
  protected $fillable = [
    'status',
    'criteria',
    'related_id',
    'related_entity',
  ];
  
  public function products()
  {
    return $this->belongsToMany(Product::class, 'icommerce__product_list')
      ->withPivot('id', 'item_option_value_id', 'price')
      ->withTimestamps()
      ->using(ProductList::class);
  }
  
}
