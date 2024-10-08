<?php

namespace Modules\Icommerce\Entities;

use Modules\Core\Icrud\Entities\CrudModel;

class SubscriptionStatusHistory extends CrudModel
{
 
  protected $table = 'icommerce__subscription_status_history';
  public $transformer = 'Modules\Icommerce\Transformers\SubscriptionStatusHistoryTransformer';
  public $repository = 'Modules\Icommerce\Repositories\SubscriptionStatusHistoryRepository';
  public $requestValidation = [
      'create' => 'Modules\Icommerce\Http\Requests\CreateSubscriptionStatusHistoryRequest',
      'update' => 'Modules\Icommerce\Http\Requests\UpdateSubscriptionStatusHistoryRequest',
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
    'subscription_id',
    'status_id',
    'notify',
    'comment'
  ];
  
  public function subscription()
  {
    return $this->belongsTo(Subscription::class);
  }

  public function getStatusLabelAttribute()
  {
    return (new SubscriptionStatus())->get($this->status_id);
  }

}
