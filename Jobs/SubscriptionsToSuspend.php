<?php

namespace Modules\Icommerce\Jobs;


use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

use Modules\Icommerce\Entities\Subscription;
use Modules\Icommerce\Entities\SubscriptionStatus;


class SubscriptionsToSuspend implements ShouldQueue
{
    
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
   
    /**
     * vars
     */
    private $log;

    /**
     * 
     */
    public function __construct()
    {
        $this->log = 'Icommerce: Jobs|SubscriptionsToSuspend|';
    }

    /**
     * Handle | Init
     */
    public function handle()
    {
        \DB::beginTransaction();
        try{

            //Base Att
            $nowDate = date('Y-m-d');
           
            //Get Subscriptions to due (Payment Pending | Days For Suspension)
            $subscriptions = Subscription::select(
                "id",
                "status_id",
                "customer_id",
                "order_item_id",
                "option_value_description",
                "due_date",
                "payment_method",
                'days_for_suspension'
            )->where("status_id", SubscriptionStatus::PAYMENT_PENDING)
            ->whereRaw(\DB::raw("DATEDIFF('$nowDate',due_date) >= days_for_suspension"))
            ->get();


            //Info msj
            \Log::info($this->log."Total: ".count($subscriptions));

            //Exist Subscriptions to check
            if(count($subscriptions) > 0) 
            {   
                //Each subscription expired
                foreach ($subscriptions as $subscription) 
                {
                    //Update Status Subscription
                    $subscription->status_id = SubscriptionStatus::SUSPENDED;
                    $subscription->save();
                    \Log::info($this->log."Suspended -> SubscriptionId: ".$subscription->id);
                }
               
            }

            //FINAL COMMIT
            \DB::commit();

        } catch (\Exception $e) {
            
            \DB::rollback();

            \Log::info($this->log."ERROR");
            \Log::Error($e);
        }
       

    }
  
   
}