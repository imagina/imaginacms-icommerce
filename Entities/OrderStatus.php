<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class OrderStatus extends CrudModel
{
  use Translatable;

  protected $table = 'icommerce__order_statuses';
  public $transformer = 'Modules\Icommerce\Transformers\OrderStatusTransformer';
  public $repository = 'Modules\Icommerce\Repositories\OrderStatusRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateOrderStatusRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateOrderStatusRequest',
    ];
  //Instance external/internal events to dispatch with extraData
  public $dispatchesEventsWithBindings = [
    //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
    'created' => [],
    'creating' => [],
    'updated' => [],
    'updating' => [],
    'deleting' => [],
    'deleted' => []
  ];
  public $translatedAttributes = ['title'];
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
