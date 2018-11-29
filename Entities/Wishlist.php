<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
  
  protected $table = 'icommerce__wishlists';

  protected $fillable = [
    'user_id',
    'product_id',
    'options'
  ];
  
  protected $fakeColumns = ['options'];
  
  protected $casts = [
    'options' => 'array'
  ];
  
  
  public function product()
  {
    return $this->belongsTo(Product::class);
  }
  
  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }
  
}
