<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
  
  protected $table = 'icommerce__order_status_history';

  protected $fillable = [
    'order_id',
    'status',
    'notify',
    'comment'
  ];
  
  public function order()
  {
    return $this->belongsTo(Order::class);
  }

  public function orderStatus()
  {
    return $this->belongsTo(OrderStatus::class,'status');
  }

}
