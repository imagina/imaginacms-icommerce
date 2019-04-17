<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
  use Translatable;
  
  protected $table = 'icommerce__tags';
  public $translatedAttributes = [
    'title',
    'slug'
  ];
  protected $fillable = [
  
  ];
  
  public function products()
  {
    return $this->belongsToMany(Product::class, 'icommerce__product_tag')->withTimestamps();
  }
  
}
