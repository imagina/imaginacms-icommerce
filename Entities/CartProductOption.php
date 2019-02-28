<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CartProductOption extends Model
{
    use Translatable;

    protected $table = 'icommerce__cart_product_options';

    public $translatedAttributes = [];

    protected $fillable = [
        'cart_product_id',
        'product_option_id',
        'product_option_value_id'
    ];

    public function cartproduct()
    {
        return $this->belongsTo(CartProduct::class);
    }


}
