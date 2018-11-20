<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Order_Shipment extends Model
{
    use HasTranslations;

    protected $table = 'icommerce__order_shipment';
   
}