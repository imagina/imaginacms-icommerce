<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Ilocations\Entities\Country;
use Modules\Ilocations\Entities\Province;

class Order extends Model
{

    protected $table = 'icommerce__orders';

    protected $fillable = [
        'invoice_nro',
        'invoice_prefix',
        'total',
        'status_id',
        'customer_id',
        'added_by_id',
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
        'payment_name',
        'shipping_first_name',
        'shipping_last_name',
        'shipping_company',
        'shipping_address_1',
        'shipping_address_2',
        'shipping_city',
        'shipping_zip_code',
        'shipping_country_code',
        'shipping_zone',
        'shipping_address_format',
        'shipping_custom_field',
        'shipping_method',
        'shipping_code',
        'shipping_amount',
        'store_id',
        'store_name',
        'store_address',
        'store_phone',
        'tax_amount',
        'comment',
        'tracking',
        'currency_id',
        'currency_code',
        'currency_value',
        'ip',
        'user_agent',
        'key',
        'options',
        'returned_stock'
    ];


    protected $casts = [
        'options' => 'array'
    ];

    public function customer()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
    }

    public function addedBy()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'added_by_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'icommerce__order_item')
            ->withPivot(
                'title', 'reference', 'quantity',
                'price', 'total', 'tax', 'reward')
            ->withTimestamps()
            ->using(OrderItem::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'icommerce__coupon_order_history')
            ->withPivot('amount')
            ->withTimestamps();
    }

    public function orderHistory()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }


    public function orderOption()
    {
        return $this->hasMany(OrderOption::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function store()
    {
        if (is_module_enabled('Marketplace')) {
            return $this->belongsTo('Modules\Marketplace\Entities\Store');
        }
        return $this->belongsTo(Store::class);
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

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function getUrlAttribute()
    {
        return \URL::route(\LaravelLocalization::getCurrentLocale() .  '.icommerce.store.order.show',["orderId" => $this->id, "orderKey" => $this->key]);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    public function paymentCountry()
    {
      return $this->belongsTo(Country::class, 'payment_country', 'iso_2')->with('translations');
    }

    public function shippingCountry()
    {
      return $this->belongsTo(Country::class, 'shipping_country_code','iso_2')->with('translations');
    }

    public function paymentDepartment()
    {
      return $this->belongsTo(Province::class, 'payment_zone','iso_2')->with('translations');
    }

    public function shippingDepartment()
    {
      return $this->belongsTo(Province::class, 'shipping_zone','iso_2')->with('translations');
    }
}
