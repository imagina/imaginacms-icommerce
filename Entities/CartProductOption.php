<?php

namespace Modules\Icommerce\Entities;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CartProductOption extends Pivot
{
   

    protected $table = 'icommerce__cart_product_options';

    protected $fillable = [
        'cart_product_id',
        'product_option_id',
        'product_option_value_id'
    ];

    public function cartproduct()
    {
        return $this->belongsTo(CartProduct::class);
    }

    public function productoptionvalue()
    {
        return $this->belongsTo(ProductOptionValue::class);
    }


}
