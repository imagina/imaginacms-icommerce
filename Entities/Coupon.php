<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Coupon extends Model
{

  protected $table = 'icommerce__coupons';

  protected $fillable = [
    'code',
    'type',
    'category_id',
    'product_id',
    'customer_id',
    'discount',
    'type_discount',
    'logged',
    'shipping',
    'date_start',
    'date_end',
    'quantity_total',
    'quantity_total_customer',
    'status',
    'options',
  ];
  protected $fakeColumns = ['options'];


  protected $casts = [
    'options' => 'array'
  ];

  public function product(){
    return $this->belongsTo(Product::class);
  }

  public function category()
  {
    return $this->belongsTo(Category::class);
  }

  public function customer()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
  }

  public function orders()
  {
    return $this->belongsToMany(Order::class, 'icommerce__coupon_order_history');
  }


  public function getUsesTotalAttribute()
  {
    return $this->has('orders')->count();
  }

  public function getUsesTotalPerUserAttribute()
  {
    if (Auth::id() == null ){
      return 0;
    }
    return $this->whereHas('orders', function ($query) {
      $query->where('icommerce__coupon_order_history.customer_id', Auth::id());
    })->count();
  }

}
