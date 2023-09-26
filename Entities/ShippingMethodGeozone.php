<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ShippingMethodGeozone extends Pivot
{
    protected $table = 'icommerce__shipping_methods_geozones';

    protected $fillable = [
        'id',
        'shipping_method_id',
        'geozone_id',
    ];
}
