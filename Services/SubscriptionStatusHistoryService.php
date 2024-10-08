<?php

namespace Modules\Icommerce\Services;


class SubscriptionStatusHistoryService
{
    
    private $log; 
    private $subscriptionStatusHistory;

    /**
     * Construct
     */
    public function __construct()
    {   
        $this->log = "Icommerce: Services|SubscriptionStatusHistoryService|";
        $this->subscriptionStatusHistory = app("Modules\Icommerce\Repositories\SubscriptionStatusHistoryRepository");
    }

    /**
    *  Create a Subscription Status History
    */
    public function create($data)
    {
        \Log::info($this->log."Create");

        $data = [
            "subscription_id" => $data['subscription_id'],
            "status_id" => $data['status_id'],
            "notify" => $data['notify'] ?? 0,
            "comment" => $data['comment'] ?? null,
        ];

        //Create History
        $history = $this->subscriptionStatusHistory->create($data);

        return $history;
        
    }   


}