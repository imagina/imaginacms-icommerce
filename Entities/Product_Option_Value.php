<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;


class Product_Option_Value extends Model
{


    protected $table = 'icommerce__product_option_values';

    protected $fillable = [
      'product_option_id',
      'product_id',
      'option_id',
      'option_value_id',
      'quantity',
      'subtract',
      'price',
      'price_prefix',
      'points',
      'points_prefix',
      'weight',
      'weight_prefix',
      'children_option_value_id'
    ];


    //************* OJO DUDAS PROBAR ********************
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //************* OJO DUDAS PROBAR ********************
    public function product_option()
    {
        return $this->belongsTo(Product_Option::class);
    }

    //************* OJO DUDAS PROBAR ********************
    public function option()
    {
        return $this->belongsTo(Option::class);
    }

    //************* OJO DUDAS PROBAR ********************
    public function option_value()
    {
        return $this->belongsTo(Option_Value::class);
    }
    public function child_option_value()
    {
        return $this->belongsTo('Modules\Icommerce\Entities\Option_Value','children_option_value_id');
    }


    public function order_option(){
    	return $this->hasMany(Order_Option::class);
    }


}
