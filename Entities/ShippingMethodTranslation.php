<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class ShippingMethodTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description'
    ];

    protected $table = 'icommerce__shipping_method_translations';
}
