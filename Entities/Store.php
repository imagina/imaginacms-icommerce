<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Ilocations\Entities\City;
use Modules\Ilocations\Entities\Country;
use Modules\Ilocations\Entities\Province;

class Store extends Model
{
    protected $table = 'icommerce__stores';

    protected $fillable = [
        'name',
        'address',
        'phone',
        'country_id',
        'province_id',
        'city_id',
        'polygon',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
        'polygon' => 'array'
    ];

  public function city()
  {
    return $this->belongsTo(City::class, 'city_id');
  }

  public function country()
  {
    return $this->belongsTo(Country::class, 'country_id');
  }

  public function department()
  {
    return $this->belongsTo(Province::class, 'province_id');
  }

}
