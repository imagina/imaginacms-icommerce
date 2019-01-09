<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $table = 'icommerce__transactions';

    protected $fillable = [
      'external_code',
      'order_id',
      'payment_method_id',
      'amount',
      'status',
      'external_status',
    ];
}
