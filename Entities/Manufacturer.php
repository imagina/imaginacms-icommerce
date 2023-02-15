<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Support\Traits\MediaRelation;
use Illuminate\Support\Str;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Manufacturer extends Model
{
  use Translatable, NamespacedEntity, MediaRelation, BelongsToTenant;
  
  protected $table = 'icommerce__manufacturers';
  public $translatedAttributes = [
    'name',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'translatable_options'
  ];
  protected $fillable = [
    'status',
    'options',
    'sort_order',
    'store_id'
  ];
  
  protected $casts = [
    'options' => 'array',
    'active' => 'boolean'
  ];
  
  public function store()
  {
    if (is_module_enabled('Marketplace')) {
      return $this->belongsTo('Modules\Marketplace\Entities\Store');
    }
    return $this->belongsTo(Store::class);
  }
  
  public function products()
  {
    return $this->hasMany(Product::class);
  }
  
  /*
  * Polimorphy Relations
  */
  public function coupons()
  {
    return $this->morphToMany(Coupon::class, 'couponable', 'icommerce__couponables');
  }
  
  public function getOptionsAttribute($value)
  {
    try {
      return json_decode(json_decode($value));
    } catch (\Exception $e) {
      return json_decode($value);
    }
  }
  
  public function getUrlAttribute($locale = null)
  {
    $url = "";
    $currentLocale = $locale ?? locale();
    if (!is_null($locale)) {
      $this->slug = $this->getTranslation($locale)->slug;
    }
    
    if (empty($this->slug)) return "";
    
    if (!(request()->wantsJson() || Str::startsWith(request()->path(), 'api'))) {
      
      $currentDomain = !empty($this->organization_id) ? tenant()->domain ?? tenancy()->find($this->organization_id)->domain :
        parse_url(config('app.url'), PHP_URL_HOST);
      
      if (config("app.url") != $currentDomain) {
        $savedDomain = config("app.url");
        config(["app.url" => "https://" . $currentDomain]);
      }
      
      $url = Str::replace(["{manufacturerSlug}"],[$this->slug], trans('icommerce::routes.store.index.manufacturer', [], $currentLocale));
      $url = \LaravelLocalization::localizeUrl('/' . $url, $currentLocale);
      
      if (isset($savedDomain) && !empty($savedDomain)) config(["app.url" => $savedDomain]);
      
    }
    return $url;
  }
  
  
  public function getMainImageAttribute()
  {
    $thumbnail = $this->files->where('zone', 'mainimage')->first();
    if (!$thumbnail) {
      if (isset($this->options->mainimage)) {
        $image = [
          'mimeType' => 'image/jpeg',
          'path' => url($this->options->mainimage)
        ];
      } else {
        $image = [
          'mimeType' => 'image/jpeg',
          'path' => url('modules/iblog/img/post/default.jpg')
        ];
      }
    } else {
      $image = [
        'mimeType' => $thumbnail->mimetype,
        'path' => $thumbnail->path_string
      ];
    }
    return json_decode(json_encode($image));
  }
  
  public function getSecondaryImageAttribute()
  {
    $thumbnail = $this->files->where('zone', 'secondaryimage')->first();
    if (!$thumbnail) {
      $image = [
        'mimeType' => 'image/jpeg',
        'path' => url('modules/iblog/img/post/default.jpg')
      ];
    } else {
      $image = [
        'mimeType' => $thumbnail->mimetype,
        'path' => $thumbnail->path_string
      ];
    }
    return json_decode(json_encode($image));
  }
  
}
