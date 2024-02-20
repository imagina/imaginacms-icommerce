<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Warehouse extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__warehouses';
  public $transformer = 'Modules\Icommerce\Transformers\WarehouseTransformer';
  public $repository = 'Modules\Icommerce\Repositories\WarehouseRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateWarehouseRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateWarehouseRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public $translatedAttributes = [
    'title',
    'slug',
    'description'
  ];
  protected $fillable = [
    'lat',
    'lng',
    'address',
    'status',
    'options',
    'country_id',
    'province_id',
    'city_id',
    'polygon_id',
    'default',
    'users_to_notify',
    'emails_to_notify'
  ];

  protected $casts = [
    'options' => 'array',
    'users_to_notify' => 'array',
    'emails_to_notify' => 'array'
  ];

  
  public function country()
  {
      return $this->belongsTo("Modules\Ilocations\Entities\Country");
  }

  public function province()
  {
    return $this->belongsTo("Modules\Ilocations\Entities\Province");
  }

  public function city()
  {
    return $this->belongsTo("Modules\Ilocations\Entities\City");
  }

  public function polygon()
  {
    return $this->belongsTo("Modules\Ilocations\Entities\Polygon");
  }

  public function orders()
  {
    return $this->hasMany(Order::class);
  }

  public function cartProducts()
  {
    return $this->hasMany(CartProduct::class);
  }

  /**
   * Relation with Iprofile Address
   */
  public function profileAddresses()
  { 
    return $this->hasMany("Modules\Iprofile\Entities\Adress");
  }
  


}
