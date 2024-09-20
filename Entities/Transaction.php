<?php

namespace Modules\Icommerce\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Transaction extends CrudModel
{

  protected $table = 'icommerce__transactions';
  public $transformer = 'Modules\Icommerce\Transformers\TransactionTransformer';
  public $repository = 'Modules\Icommerce\Repositories\TransactionRepository';
  public $requestValidation = [
    'create' => 'Modules\Icommerce\Http\Requests\CreateTransactionRequest',
    'update' => 'Modules\Icommerce\Http\Requests\UpdateTransactionRequest',
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
    return $this->belongsTo(OrderStatus::class, 'status');
  }
}