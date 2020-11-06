<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{

  protected $table = 'icommerce__product_lists';

  protected $fillable = [
    'product_id',
    'price_list_id',
    'price'
    ];

  public function product(){
    $this->belongsTo(Product::class);
  }

  public function priceList(){
    $this->belongsTo(PriceList::class);
  }

}
