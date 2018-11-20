<?php

namespace Modules\Icommerce\Entities;

// use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TaxRates extends Model
{
    // use Translatable;

    protected $table = 'icommerce__taxrates';
    // public $translatedAttributes = [];
    protected $fillable = [];

    public function geozone()
    {
        return $this->belongsTo('Modules\Ilocations\Entities\Geozones', 'geozone_id');
    }
}
