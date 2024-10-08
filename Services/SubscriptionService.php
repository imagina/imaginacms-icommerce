<?php

namespace Modules\Icommerce\Services;

use Carbon\Carbon;
use Modules\Icommerce\Entities\SubscriptionStatus;
use Modules\User\Entities\Sentinel\User;

class SubscriptionService
{
    
    private $log; 
    private $subscriptionRepository;

    /**
     * Construct
     */
    public function __construct()
    {   
        $this->log = "Icommerce: Services|SubscriptionService|";
        $this->subscriptionRepository = app("Modules\Icommerce\Repositories\SubscriptionRepository");
    }

    /**
    *  Create a Subscription
    */
    public function create($order,$orderItem,$orderOption)
    {
        \Log::info($this->log."Create");

        $frequency = $orderOption->optionValue->options;
        $dueDate = Carbon::now()->addDays($frequency->days);

        $finalData = [
            'order_id' => $order->id,
            'order_item_id' => $orderItem->id,
            'product_id' => $orderItem->product->id,
            'customer_id' => $order->customer_id,
            'order_option_id' => $orderOption->id,
            'option_description' => $orderOption->option_description,
            'option_value_description' => $orderOption->option_value_description,
            'payment_method' => $order->payment_method,
            'payment_code' => $order->paymentMethod->name, //Mejor guardar el name por si en algun futuro lo eliminaran y volvieran a agregar
            'currency_id' => $order->currency_id,
            'currency_code' => $order->currency_code,
            'currency_value' => $order->currency_value,
            'price' => $order->total,
            'frequency' => $frequency->days,
            'due_date' => $dueDate,
            'status_id' => SubscriptionStatus::ACTIVE
        ];

        //Validation options with setting
        $options = $orderOption->options;

        $finalData['days_before_due'] = isset($options->daysBeforeDue) ? $options->daysBeforeDue : setting('icommerce::daysBeforeDue',null,0);
        $finalData['days_for_suspension'] = isset($options->daysForSuspension) ? $options->daysForSuspension : setting('icommerce::daysForSuspension',null,5);

        //Final Create
        $subscription = $this->subscriptionRepository->create($finalData);

        return $subscription;
        
    } 
    
    /**
    * Get emails and broadcast information
    */
    public function getEmailsAndBroadcast($subscription)
    {
        
        $emailTo = [];
        $broadcastTo = [];

        //Process with Setting
        $usersToNotify = json_decode(setting("icommerce::usersToNotify"));
        if(count($usersToNotify)>0){
            //Setting Infor
            $users = User::whereIn("id", $usersToNotify)->get();
            $emailTo = array_merge($emailTo, $users->pluck('email')->toArray());
            $broadcastTo = $users->pluck('id')->toArray();
        }

        // Data Notification from Setting
        $to["email"] = $emailTo;
        $to["broadcast"] = $broadcastTo;

        // Data Notification from Subscription
        array_push($to["email"],$subscription->customer->email);
        array_push($to["broadcast"],$subscription->customer->id);

        //Data only emails from setting
        $settingEmailTo = json_decode(setting("icommerce::form-emails", null, "[]"));
        if (count($settingEmailTo)>0){
          $to['email'] = array_merge($to['email'], $settingEmailTo);
        }
        
        
        return $to;
    }


}