<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use Translatable;

    protected $table = 'icommerce__order_statuses';
    public $translatedAttributes = [
      'title'
    ];
    protected $fillable = [
      'status',
      'parent_id'
    ];

    public function orders()
    {
      return $this->hasMany(Order::class);
    }

    public function orderHistories()
    {
      return $this->hasMany(OrderStatusHistory::class);
    }

    public function transactions()
    {
      return $this->hasMany(Transactions::class);
    }

}
