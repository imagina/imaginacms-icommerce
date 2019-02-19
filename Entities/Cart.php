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

  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'icommerce__cart_product')->withPivot('id', 'quantity','price');
  }

}
