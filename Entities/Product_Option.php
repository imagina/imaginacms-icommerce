<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Product_Option extends Pivot
{
    
    protected $table = 'icommerce__product_option';

    protected $fillable = ['product_id','option_id','value','required'];

    public function product_option_values(){
        return $this->hasMany(Product_Option_Value::class);
    }

    public function order_option(){
        return $this->hasMany(Order_Option::class);
    }

    public function getCreatedAtColumn()
    {
        return 'created_at';
    }
 
    public function getUpdatedAtColumn()
    { 
        return 'updated_at';
    }


}