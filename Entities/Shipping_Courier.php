<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
//use Spatie\Translatable\HasTranslations;

use Dimsav\Translatable\Translatable;

use Modules\Bcrud\Support\Traits\CrudTrait;

class Shipping_Courier extends Model
{
    
	use CrudTrait;
    protected $table = 'icommerce__shipping_couriers';

    protected $fillable = ['code','name','status'];

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'icommerce__order_shipment')->withPivot('traking_number')->withTimestamps();
    }

}