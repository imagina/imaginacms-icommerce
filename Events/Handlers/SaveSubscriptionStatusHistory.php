<?php

namespace Modules\Icommerce\Events\Handlers;


class SaveSubscriptionStatusHistory
{
  
  public $log;
  private $subscriptionStatusHistoryService;
  
  public function __construct()
  {
    $this->log = 'Icommerce: Handler|SaveSubscriptionStatusHistory|';
    $this->subscriptionStatusHistoryService = app("Modules\Icommerce\Services\SubscriptionStatusHistoryService");;
    
  }
  
  public function handle($event)
  {

    \Log::info($this->log);
    
    // Get All params Event
    $params = $event->params;

    // Get Model
    $subscription = $params['model'];

    //Fix data
    $data = [
      "subscription_id" => $subscription->id,
      "status_id" => $subscription->status_id
    ];

    //Create History
    $this->subscriptionStatusHistoryService->create($data);

    
  }// If handle

  
  
  
}
