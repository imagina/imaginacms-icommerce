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
    
      return json_decode(json_decode($value));

  }

  public function setOptionsAttribute($value) {
    
    return json_encode($value);

  }

}
