<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
  use Translatable;
  
  public $translatedAttributes = [
    'title',
    'description'
  ];
  
  protected $table = 'icommerce__payment_methods';
  
  protected $fillable = [
    'status',
    'name',
    'options'
  ];
  
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];


  public function getOptionsAttribute($value) {
    
      return json_decode($value);

  }

  public function setOptionsAttribute($value) {
    
      $this->attributes['options'] = json_encode($value);
    
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function geozones()
  {
      return $this->belongsToMany('Modules\Ilocations\Entities\Geozones', 'icommerce__payment_methods_geozones','payment_method_id','geozone_id')->withTimestamps();
  }

}
