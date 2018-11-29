<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{

    protected $table = 'icommerce__transactions';

    protected $fillable = [
      'order_id',
      'name',
      'amount',
      'status'
    ];
}
