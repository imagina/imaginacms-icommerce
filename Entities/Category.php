<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
  use Translatable;
  
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
  protected function setSlugAttribute($value){
    
    if($this->parent_id==0){
      if(!empty($value)){
        $this->attributes['slug'] = str_slug($value,'-');
      }else{
        $this->attributes['slug'] = str_slug($this->title,'-');
      }
    }else{
      $this->attributes['slug'] = $this->parent->slug.'/'.str_slug($this->title,'-');
    }
    
    
  }
  
  public function getUrlAttribute() {
    
    return url(\LaravelLocalization::getCurrentLocale() . '/'.$this->slug);
    
  }
  public function getOptionsAttribute($value) {
    return json_decode(json_decode($value));
  }
}
