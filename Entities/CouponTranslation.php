<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class CouponTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'name'
    ];
    protected $table = 'icommerce__coupon_translations';
}
