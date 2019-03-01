<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PaymentMethodGeozone extends Model
{
   
    protected $table = 'icommerce__payment_methods_geozones';
    protected $fillable = [
    	"id",
        "payment_method_id",
        "geozone_id"
    ];

}
