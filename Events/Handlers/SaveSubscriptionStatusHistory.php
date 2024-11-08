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

    // Case | Data from API Subscription
    $extra = $params['data'];

    if(isset($extra['subscriptionHistory']))
      if(isset($extra['subscriptionHistory']['comment'])) $data['comment'] = $extra['subscriptionHistory']['comment'];
  

    //Create History
    $this->subscriptionStatusHistoryService->create($data);

    
  }// If handle

  
  
  
}
