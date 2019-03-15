<?php

namespace Modules\Icommerce\Entities;

use Dimsav\Translatable\Translatable;
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

}
