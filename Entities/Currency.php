<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;

class Currency extends Model
{
  use Translatable, AuditTrait;
  
  protected $table = 'icommerce__currencies';
  public $translatedAttributes = [
    'name'
  ];
  protected $fillable = [
    'code',
    'symbol_left',
    'symbol_right',
    'decimals',
    'decimal_separator',
    'thousands_separator',
    'store_id',
    'value',
    'status',
    'default_currency',
    'language',
    'options'
  
  ];
  
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public function store()
  {
    if (is_module_enabled('Marketplace')) {
      return $this->belongsTo('Modules\Marketplace\Entities\Store');
    }
    return $this->belongsTo(Store::class);
  }
  
  public function orders()
  {
    return $this->hasMany(Order::class);
  }
  
}
