<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ShippingMethodGeozone extends Pivot
{
    
    protected $table = 'icommerce__shipping_methods_geozones';
    protected $fillable = [
        "id",
        "shipping_method_id",
        "geozone_id"
    ];
}
