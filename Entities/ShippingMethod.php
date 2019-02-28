<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use Translatable;

    protected $table = 'icommerce__shipping_methods';
    
    public $translatedAttributes = [
        'title',
        'description'
    ];

    protected $fillable = [
        'status',
        'name',
        'options'
    ];

    protected $fakeColumns = ['options'];
  
    protected $casts = [
        'options' => 'array'
    ];

    public function getOptionsAttribute($value) {
    
        return json_decode($value);
  
    }
  
    public function setOptionsAttribute($value) {
      
        $this->attributes['options'] = json_encode($value);
      
    }

    public function geozones()
    {
        return $this->belongsToMany(ShippingMethodGeozone::class, 'icommerce__shipping_methods_geozones')->withTimestamps();
    }


}
