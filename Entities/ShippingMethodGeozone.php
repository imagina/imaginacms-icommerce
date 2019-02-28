<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ShippingMethodGeozone extends Model
{
    use Translatable;

    protected $table = 'icommerce__shippingmethodgeozones';
    public $translatedAttributes = [];
    protected $fillable = [];
}
