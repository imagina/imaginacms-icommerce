<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  
  protected $table = 'icommerce__orders';

  protected $fillable = [
    'invoice_nro',
    'invoice_prefix',
    'total',
    'status_id',
    'user_id',
    'first_name',
    'last_name',
    'email',
    'telephone',
    'payment_first_name',
    'payment_last_name',
    'payment_company',
    'payment_nit',
    'payment_email',
    'payment_address_1',
    'payment_address_2',
    'payment_city',
    'payment_zip_code',
    'payment_country',
    'payment_zone',
    'payment_address_format',
    'payment_custom_field',
    'payment_method',
    'payment_code',
    'shipping_first_name',
    'shipping_last_name',
    'shipping_company',
    'shipping_address_1',
    'shipping_address_2',
    'shipping_city',
    'shipping_zip_code',
    'shipping_country',
    'shipping_zone',
    'shipping_address_format',
    'shipping_custom_field',
    'shipping_method',
    'shipping_code',
    'shipping_amount',
    'tax_amount',
    'comment',
    'tracking',
    'currency_id',
    'currency_code',
    'currency_value',
    'ip',
    'user_agent',
    'key',
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
    return $this->belongsToMany(Product::class, 'icommerce__order_item')->withPivot('title', 'reference', 'quantity', 'price', 'total', 'tax', 'reward')->withTimestamps()->using(OrderItem::class);
  }
  
  public function orderProducts()
  {
    return $this->hasMany(OrderItem::class, 'order_id');
  }
  
  public function coupons()
  {
    return $this->belongsToMany(Coupon::class, 'icommerce__coupon_history')->withPivot('amount')->withTimestamps();
  }
  
  public function orderHistory()
  {
    return $this->hasMany(OrderStatusHistory::class);
  }
  
  
  public function orderOption()
  {
    return $this->hasMany(OrderOption::class);
  }
  
  public function currency()
  {
    return $this->belongsTo(Currency::class);
  }
  
  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }
  
  public function shippings()
  {
    return $this->hasMany(Shipping::class);
  }
  
}
