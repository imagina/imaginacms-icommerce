<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
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
    'customer'
  ];
  
  public function geozone()
  {
    return $this->belongsTo('Modules\Ilocations\Entities\Geozones', 'geozone_id');
  }
  
}
