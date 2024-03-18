<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Core\Support\Traits\AuditTrait;

class OrderStatusHistory extends CrudModel
{

  protected $table = 'icommerce__order_status_history';
  public $transformer = 'Modules\Icommerce\Transformers\OrderStatusHistoryTransformer';
  public $repository = 'Modules\Icommerce\Repositories\OrderStatusHistoryRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateOrderStatusHistoryRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateOrderStatusHistoryRequest',
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

    protected $fillable = [
        'order_id',
        'status',
        'notify',
        'comment',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'status');
    }
}
