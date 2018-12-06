<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
  use Translatable;
  
  protected $table = 'icommerce__coupons';
  public $translatedAttributes = [
    'name'
  ];
  protected $fillable = [
    'code',
    'type',
    'discount',
    'logged',
    'shipping',
    'total',
    'date_start',
    'date_end',
    'uses_total',
    'status',
    'added_by_id',
    'options'
  ];
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public function products(){
    return $this->belongsToMany(Product::class,'icommerce__coupon_product')->withTimestamps();
  }
  
  public function categories()
  {
    return $this->belongsToMany(Category::class,'icommerce__coupon_category')->withTimestamps();
  }
  
  public function orders(){
    return $this->belongsToMany(Order::class, 'icommerce__coupon_history')->withPivot('amount')->withTimestamps();
  }
  
}
