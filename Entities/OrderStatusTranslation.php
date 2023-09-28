<?php

namespace Modules\Icommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class OrderStatusTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    protected $table = 'icommerce__order_status_trans';
}
