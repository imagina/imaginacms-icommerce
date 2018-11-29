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
      'user_id',
      'amount'
    ];
}
