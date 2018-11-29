<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
  use Translatable;
  
  protected $table = 'icommerce__manufacturers';
  public $translatedAttributes = [
    'name'
  ];
  protected $fillable = [
    'status',
    'options'
  ];
  
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public function products()
  {
    return $this->hasMany(Product::class);
  }
  
  public function getOptionsAttribute($value)
  {
    return json_decode(json_decode($value));
  }
  
  public function saveFileInOptions(&$options, $attribute, $dest_path)
  {
    
    if (property_exists($options, $attribute)) {
      //Simulate a real column so we can use tha function uploadFileToDisk
      $this->attributes[$attribute] = $this->options->{$attribute};
      $this->uploadFileToDisk($options->{$attribute}, $attribute, "publicmedia", $dest_path);
      
      $options->{$attribute} = $this->attributes[$attribute];
      
      unset($this->attributes[$attribute]);
      
    } else {
      $options->{$attribute} = (!empty($this->options->{$attribute})) ? $this->options->{$attribute} : '';
    }
    
  }
  
  public function getUrlAttribute()
  {
    return \URL::route(\LaravelLocalization::getCurrentLocale() . '.icommerce.manufacturers.show', [$this->id]);
  }
}
