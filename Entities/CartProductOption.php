<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CartProductOption extends Model
{
    use Translatable;

    protected $table = 'icommerce__cart_product_options';
    public $translatedAttributes = [];
    protected $fillable = [];
}
