<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class ShippingMethodTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'shipping_method_id',
        'locale',
    ];

    protected $table = 'icommerce__shipping_method_translations';
}
