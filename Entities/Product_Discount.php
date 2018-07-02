<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class Product_Discount extends Model
{
    

    protected $table = 'icommerce__product_discounts';

    protected $fillable = ['product_id','quantity','priority','price','datestart','dateend'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
