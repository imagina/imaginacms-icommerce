<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodGeozone extends Model
{
    protected $table = 'icommerce__payment_methods_geozones';

    protected $fillable = [
        'id',
        'payment_method_id',
        'geozone_id',
    ];
}
