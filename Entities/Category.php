<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\Media\Entities\File;
use Modules\Core\Traits\NamespacedEntity;


class Category extends Model
{
  use Translatable, NamespacedEntity, MediaRelation;
  
  protected $table = 'icommerce__categories';
  
  public $translatedAttributes = [
    'title',
    'slug',
    'description',
    'meta_title',
    'meta_description'
  ];
  protected $fillable = [
    'parent_id',
    'options',
    'show_menu'
  ];
  
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public function parent()
  {
    return $this->belongsTo('Modules\Icommerce\Entities\Category', 'parent_id');
  }
  
  public function children()
  {
    return $this->hasMany('Modules\Icommerce\Entities\Category', 'parent_id');
  }
  
  public function products()
  {
    return $this->belongsToMany('Modules\Icommerce\Entities\Product','icommerce__product_category')->withTimestamps();
  }

  public function coupons()
  {
    return $this->belongsToMany('Modules\Icommerce\Entities\Coupon','icommerce__coupon_category')->withTimestamps();
  }

  public function getUrlAttribute() {
    
    return url(\LaravelLocalization::getCurrentLocale() . '/'.$this->slug);
    
  }

  public function getOptionsAttribute($value) {
    return json_decode(json_decode($value));
  }

  public function getMainImageAttribute()
  {
    $thumbnail = $this->files()->where('zone', 'mainimage')->first();
    if(!$thumbnail) return [
      'mimeType' => 'image/jpeg',
      'path' =>url('modules/iblog/img/post/default.jpg')
    ];
    return [
      'mimeType' => $thumbnail->mimetype,
      'path' => $thumbnail->path_string
    ];
  }
}
