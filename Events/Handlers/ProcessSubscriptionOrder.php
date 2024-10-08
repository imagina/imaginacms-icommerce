<?php

namespace Modules\Icommerce\Events\Handlers;

use Modules\Icommerce\Entities\SubscriptionStatus;
use Carbon\Carbon;

class ProcessSubscriptionOrder
{
  
  public $log;
  private $subscriptionService;
  
  public function __construct()
  {
    $this->log = 'Icommerce: Handler|ProcessSubscriptionOrder|';
    $this->subscriptionService = app("Modules\Icommerce\Services\SubscriptionService");
    
  }
  
  public function handle($event)
  {

    \Log::info($this->log."INIT");
    
    $order = $event->order;

     //Order is Proccesed
     if ($order->status_id == 13) {

      //Items
      foreach ($order->orderItems as $item) 
      {
        //Options
        foreach ($item->orderOption as $orderOption) 
        {

          $option = $orderOption->option;
          //Check option to create subscription
          if(!is_null($option->group) && $option->group=="payment-frequency")
          {
           
            $subscription = $order->subscription;

            //Validation to Create subscription | Case First Time
            if(is_null($subscription)){

              \Log::info($this->log."CASE: NEW SUBSCRIPTION");

              $subscription = $this->subscriptionService->create($order,$item,$orderOption);

              //Update Order with Subscription
              $order->subscription_id = $subscription->id;
              $order->subscription_type = get_class($subscription);
              $order->save();

            }else{

              //Has a subscription | Case Recurrence
              if($order->subscription_type=="Modules\Icommerce\Entities\Subscription"){

                \Log::info($this->log."CASE: RECURRENCE SUBSCRIPTION");

                //Update Data Subscription
                $dueDate = Carbon::now()->addDays($subscription->frequency);

                $subscription->due_date = $dueDate;
                $subscription->status_id = SubscriptionStatus::ACTIVE;

                $subscription->save();

              }
            }

          }
            
        }

      }

    }

    \Log::info($this->log."END");

  }// If handle

  
  
  
}
