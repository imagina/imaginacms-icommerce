<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class ShippingMethod extends Model
{
  use Translatable, MediaRelation, BelongsToTenant;
  
  protected $table = 'icommerce__shipping_methods';
  
  public $translatedAttributes = [
    'title',
    'description'
  ];
  
  protected $fillable = [
    'status',
    'name',
    'options',
    'store_id',
    'geozone_id',
    'parent_name'
  ];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public $tenantWithCentralData = false;
  
  public function __construct(array $attributes = [])
  {
    try{
    $entitiesWithCentralData = json_decode(setting("icommerce::tenantWithCentralData", null, "[]"));
    $this->tenantWithCentralData = in_array("shippingMethods", $entitiesWithCentralData);
    }catch(\Exception $e){}
    parent::__construct($attributes);
  }
  
  public function store()
  {
    if (is_module_enabled('Marketplace')) {
      return $this->belongsTo('Modules\Marketplace\Entities\Store');
    }
    return $this->belongsTo(Store::class);
  }
  
  public function getOptionsAttribute($value)
  {
    
    return json_decode($value);
    
  }
  
  public function setOptionsAttribute($value)
  {
    
    $this->attributes['options'] = json_encode($value);
    
  }
  
  public function geozones()
  {
    return $this->belongsToMany('Modules\Ilocations\Entities\Geozones', 'icommerce__shipping_methods_geozones', 'shipping_method_id', 'geozone_id')->withTimestamps();
  }
  
  public function getMainImageAttribute()
  {
    $thumbnail = $this->files()->where('zone', 'mainimage')->first();
    if (!$thumbnail) return [
      'mimeType' => 'image/jpeg',
      'path' => url('modules/iblog/img/post/default.jpg')
    ];
    return [
      'mimeType' => $thumbnail->mimetype,
      'path' => $thumbnail->path_string
    ];
  }
}
