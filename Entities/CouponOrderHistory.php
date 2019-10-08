<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class CouponOrderHistory extends Model
{

    protected $table = 'icommerce__coupon_order_history';

    protected $fillable = [
      'coupon_id',
      'order_id',
      'customer_id',
      'amount'
    ];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
    }


}
