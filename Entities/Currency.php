<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
  use Translatable;
  
  protected $table = 'icommerce__currencies';
  public $translatedAttributes = [
    'name'
  ];
  protected $fillable = [
    'code',
    'symbol_left',
    'symbol_right',
    'decimal_place',
    'value',
    'status',
    'options'
  ];
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public function orders()
  {
    return $this->hasMany(Order::class);
  }
  
}
