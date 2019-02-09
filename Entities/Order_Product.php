<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Order_Product extends Pivot
{

    protected $table = 'icommerce__order_product';

    protected $fillable = [
    'order_id',
    'product_id',
    'title',
    'reference',
    'quantity',
    'price',
    'total',
    'tax',
    'reward'
    ];

    public function order_option(){
      return $this->hasMany(Order_Option::class,'order_product_id');
    }

}
