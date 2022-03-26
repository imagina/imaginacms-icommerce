<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
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

  protected $with = [
    'paymentMethod',
  ];

  public function paymentMethod()
  {
    return $this->belongsTo(PaymentMethod::class)->withoutTenancy();
  }

  public function orderStatus()
  {
    return $this->belongsTo(OrderStatus::class,"status");
  }

}
