<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Order extends Model
{

  use HasTranslations;
  protected $table = 'icommerce__orders';

  public $translatable = [];

  protected $fillable = [
    'invoice_nro',
    'invoice_prefix',
    'total',
    'order_status',
    'user_id',
    'first_name',
    'last_name',
    'email',
    'telephone',
    'payment_firstname',
    'payment_lastname',
    'payment_company',
    'payment_nit',
    'payment_email',
    'payment_address_1',
    'payment_address_2',
    'payment_city',
    'payment_postcode',
    'payment_country',
    'payment_zone',
    'payment_address_format',
    'payment_custom_field',
    'payment_method',
    'payment_code',
    'shipping_firstname',
    'shipping_lastname',
    'shipping_company',
    'shipping_address_1',
    'shipping_address_2',
    'shipping_city',
    'shipping_postcode',
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
    'key'
  ];

  public function user()
  {
    $driver = config('asgard.user.config.driver');
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
  }

  public function products()
  {
    return $this->belongsToMany(Product::class, 'icommerce__order_product')->withPivot('id','title', 'reference', 'quantity', 'price', 'total', 'tax', 'reward')->withTimestamps()->using(Order_Product::class);
  }

  public function order_products()
  {
    return $this->hasMany(Order_Product::class, 'order_id');
  }

  public function coupons()
  {
    return $this->belongsToMany(Coupon::class, 'icommerce__coupon_history')->withPivot('amount')->withTimestamps();
  }

  public function order_history()
  {
    return $this->hasMany(Order_History::class);
  }

  public function couriers()
  {
    return $this->belongsToMany(Shipping_Courier::class, 'icommerce__order_shipment')->withPivot('traking_number')->withTimestamps();
  }

  public function order_option()
  {
    return $this->hasMany(Order_Option::class);
  }

  public function currency()
  {
    return $this->belongsTo(Currency::class);
  }

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }

  public function shippings()
  {
    return $this->hasMany(Shipping::class);
  }


}
