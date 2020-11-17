<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    use Translatable;

    protected $table = 'icommerce__tax_rates';
    public $translatedAttributes = [
        'name'
    ];
    protected $fillable = [
        'rate',
        'type',
        'geozone_id',
        'customer',
        'tax_class_id',
        'store_id'
    ];


    public function store()
    {
        if (is_module_enabled('Marketplace')) {
            return $this->belongsTo('Modules\Marketplace\Entities\Store');
        }
        return $this->belongsTo(Store::class);
    }

    public function geozone()
    {
        return $this->belongsTo('Modules\Ilocations\Entities\Geozones', 'geozone_id');
    }


        public function taxClass()
        {
          return $this->belongsTo(TaxClass::class,'tax_class_id');
        }

}
