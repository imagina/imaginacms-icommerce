<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
  use Translatable;
  
  protected $table = 'icommerce__option_values';
  public $translatedAttributes = [
    'description'
  ];
  protected $fillable = [
    'option_id',
    'sort_order',
    'options'
  ];
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  public function option()
  {
    return $this->belongsTo(Option::class);
  }
  
  public function getOptionsAttribute($value)
  {
    return json_decode(json_decode($value));
  }
  
}
