<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
  protected $table = 'icommerce__carts';
  
  protected $fillable = [
    'user_id',
    'total',
    'ip',
    'options'
  ];
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
}
