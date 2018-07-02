<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Order_Option extends Model
{
    use HasTranslations;

    protected $table = 'icommerce__order_options';
    public $translatable = [];

    protected $fillable = ['order_id','order_product_id','product_option_id','product_option_value_id','name','value','type'];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function order_product()
    {
        return $this->belongsTo(Order_Product::class);
    }

    public function product_option()
    {
        return $this->belongsTo(Product_Option::class);
    }

    public function product_option_value()
    {
        return $this->belongsTo(Product_Option_Value::class);
    }

}
