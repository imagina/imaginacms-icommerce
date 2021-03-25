<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Modules\Ihelpers\Traits\Relationable;

class Coupon extends Model
{
    use Relationable;

    protected $table = 'icommerce__coupons';

    protected $fillable = [
        'code',
        'type',
        /*'category_id',
        'product_id',
        'customer_id',
        'store_id',*/
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
        'minimum_amount',
        'minimum_quantity_products',
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

    public function product()
    {
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


    public function couponHistories()
    {
        return $this->hasMany(CouponOrderHistory::class);
    }

    public function getUsesTotalAttribute()
    {
        return $this->has('orders')->count();
    }

    public function getUsesTotalPerUserAttribute()
    {
        if (Auth::id() == null) {
            return 0;
        }
        return $this->whereHas('orders', function ($query) {
            $query->where('icommerce__coupon_order_history.customer_id', Auth::id());
        })->count();
    }

    public function setExcludeDepartmentsAttribute($value)
    {
        $this->attributes['exclude_departments'] = json_encode($value);
    }

    public function getExcludeDepartmentsAttribute($value)
    {
        return json_decode($value);
    }

    public function setIncludeDepartmentsAttribute($value)
    {
        $this->attributes['include_departments'] = json_encode($value);
    }

    public function getIncludeDepartmentsAttribute($value)
    {
        return json_decode($value);
    }

}
