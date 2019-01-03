<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
  use Translatable;
  
  protected $table = 'icommerce__options';
  public $translatedAttributes = [
    'description'
  ];
  protected $fillable = [
    'type',
    'sort_order',
    'options'
  ];
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public function products(){
    return $this->belongsToMany(Product::class, 'icommerce__product_option')->withPivot('value', 'required')->withTimestamps()->using(Product_Option::class);
  }
  
  public function optionValues(){
    return $this->hasMany(OptionValue::class);
  }
  
}
