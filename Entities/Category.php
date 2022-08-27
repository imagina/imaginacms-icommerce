<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Modules\Media\Entities\File;
use Modules\Media\Support\Traits\MediaRelation;
use TypiCMS\NestableTrait;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Support\Str;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class
Category extends Model
{
  use Translatable, NamespacedEntity, MediaRelation, NodeTrait, BelongsToTenant;

  protected $table = 'icommerce__categories';
  protected static $entityNamespace = 'asgardcms/icommerceCategory';
  public $translatedAttributes = [
    'title',
    'h1_title',
    'slug',
    'description',
    'meta_title',
    'meta_description',
    'translatable_options'
  ];
  protected $fillable = [
    'parent_id',
    'options',
    'show_menu',
    'featured',
    'store_id',
    'status',
    'sort_order',
    'external_id',
  ];
  
  protected $width = ['files','translations'];

  protected $casts = [
    'options' => 'array'
  ];
  
  public function parent()
  {
    return $this->belongsTo(Category::class, 'parent_id');
  }

  public function children()
  {
    return $this->hasMany(Category::class, 'parent_id');
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'icommerce__product_category')->withTimestamps();
  }

  public function ownProducts()
  {
    return $this->hasMany(Product::class)->where(function ($query) {
      $query->where("date_available", "<=", date("Y-m-d", strtotime(now())));
      $query->orWhereNull("date_available");
    })->where("status", 1)
      ->whereRaw("((subtract = 1 and quantity > 0) or (subtract = 0) or (stock_status = 0))");
  }

  public function manufacturers()
  {
    return $this->belongsToMany(Manufacturer::class, 'icommerce__products')->withTimestamps();
  }

  public function store()
  {
    if (is_module_enabled('Marketplace')) {
      return $this->belongsTo('Modules\Marketplace\Entities\Store');
    }
    return $this->belongsTo(Store::class);
  }

  /*
  * Polimorphy Relations
  */
  public function coupons()
  {
    return $this->morphToMany(Coupon::class, 'couponable','icommerce__couponables');
  }

  /*
  * Mutators / Accessors
  */
  public function getUrlAttribute()
  {
    $url = "";
    $useOldRoutes = config('asgard.icommerce.config.useOldRoutes') ?? false;
    $currentLocale = locale();
    $routeName = request()->route()->getName();

    if (!(request()->wantsJson() || Str::startsWith(request()->path(), 'api'))) {
      if ($useOldRoutes) {
        $url = \URL::route($currentLocale . '.icommerce.category.' . $this->slug);
      } else {
        switch($routeName){
          case $currentLocale.".icommerce.store.index.categoryManufacturer":
            $manufacturerSlug = explode("/",request()->path())[4];
            $url = \URL::route($currentLocale . '.icommerce.store.index.categoryManufacturer', [$this->slug, $manufacturerSlug]);
            break;
          case $currentLocale.".icommerce.store.index.manufacturer":
            $manufacturerSlug = explode("/",request()->path())[2];
            $url = \URL::route($currentLocale . '.icommerce.store.index.categoryManufacturer', [$this->slug, $manufacturerSlug]);
          break;
          
          default:
            
            $url = tenant_route(request()->getHost(), $currentLocale . '.icommerce.store.index.category',[$this->slug]);
            break;
        }
      }
    }
    return $url;
  }

  public function urlManufacturer(Manufacturer $manufacturer)
  {
    $url = "";
    $useOldRoutes = config('asgard.icommerce.config.useOldRoutes') ?? false;
    if (!(request()->wantsJson() || Str::startsWith(request()->path(), 'api'))) {
      $url = \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.store.index.categoryManufacturer', [$this->slug, $manufacturer->slug]);
    }
    return $url;
  }
  public function getOptionsAttribute($value)
  {
    try {
      return json_decode(json_decode($value));
    } catch (\Exception $e) {
      return json_decode($value);
    }
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

  public function getTertiaryImageAttribute()
  {
    $thumbnail = $this->files->where('zone', 'tertiaryimage')->first();
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

  public function getLftName()
  {
    return 'lft';
  }

  public function getRgtName()
  {
    return 'rgt';
  }

  public function getDepthName()
  {
    return 'depth';
  }

  public function getParentIdName()
  {
    return 'parent_id';
  }

  // Specify parent id attribute mutator
  public function setParentAttribute($value)
  {
    $this->setParentIdAttribute($value);
  }
}
