<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{

    protected $table = 'icommerce__payment_methods';

    protected $fillable = [
      'payment_method',
      'name',

    ];
}
