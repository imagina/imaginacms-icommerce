<?php

namespace Modules\Icommerce\Services;

use Modules\Icommerce\Entities\Product;

class PaymentMethodService
{
    
    private $paymentMethodRepository;
    private $fieldRepository;
    private $log;
    public $notificationService;

    public function __construct()
    {

        $this->log = 'Icommerce: Services|PaymentMethodService|';
        $this->paymentMethodRepository = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
        $this->fieldRepository = app("Modules\Iprofile\Repositories\FieldRepository");
        $this->notificationService = app("Modules\Notification\Services\Inotification");
    }


    /*
    * Get payouts 'fieldname' from config for each payment method module
    */
    public function getPayoutsFieldName(){

        $payoutsFieldName = [];

        // Get Payment Methods Payouts
        $params = ["filter" => ["status" => 1,"payout" => 1]];
        $paymentMethods = $this->paymentMethodRepository->getItemsBy(json_decode(json_encode($params)));
        
        // Exist payment methods like payout
        if(count($paymentMethods)>0){

            // Get config field name for each payout
            foreach ($paymentMethods as $key => $paymentMethod) {
                
                $paymentInfor = [
                    'title' => $paymentMethod->title,
                    'fieldName' => config('asgard.'.$paymentMethod->name.'.config.fieldName')
                ];

                array_push($payoutsFieldName,$paymentInfor);
            }
        }else{
            $payoutsFieldName = null;
        }

        return $payoutsFieldName;

    }

    /**
    * Get a collection with the configuration of each payout for the logged in user
    * @return NULL or Collection
    */
    public function getPayoutsForUser(){

        // Get names field from configs for each payout
        $payoutsFieldName = $this->getPayoutsFieldName();
  
        if(!is_null($payoutsFieldName)){

            $payoutsConfig = [];
            $userId = \Auth::id();

            foreach ($payoutsFieldName as $key => $payout) {
           
              $params = json_decode(json_encode(["filter" => ["field" => "name", "userId" => $userId]]));
                // Check field for this user and name field
                $field = $this->fieldRepository->getItem($payout['fieldName'],$params);
                

                // Add configurations
                if(!is_null($field)){
                    $payoutInfor = array_merge($payout,['configurations' => $field->value]);
                    $pObj = (object)($payoutInfor);
                    array_push($payoutsConfig,$pObj);
                }

            }
        }else{
            $payoutsConfig = null;
        }

        //There are payouts installed but not configurations payouts for this user
        if(!is_null($payoutsConfig) && count($payoutsConfig)==0 ){
            $payoutsConfig = null;
        }else{
            $payoutsConfig = collect($payoutsConfig);
        }

        return $payoutsConfig;

    }

   
    /**
    * Process to Payment
    */
    public function checkPaymentMethod($order)
    {

        \Log::info($this->log."Check Payment Method to OrderId: ".$order->id);

        $paymenMethod =  $order->paymentMethod;

        //Validation Exist
        if(!is_null($paymenMethod))
        {
            \Log::info($this->log."Payment Method: ".$paymenMethod->name);

            $moduleName = $paymenMethod->name;

            //Es un metodo Hijo
            if(!is_null($paymenMethod->parent_name)) $moduleName = $paymenMethod->parent_name;

            //Validation Class
            $baseClass = "Modules\\".ucfirst($moduleName)."\Services\RecurrenceService";

            $isRecurrence = false;
            if(class_exists($baseClass)){
                $service = app($baseClass);
                $isRecurrence = $service->isRecurrence($moduleName);
                //Validation Method
                if($isRecurrence && method_exists($service, "init")){
                    \Log::info($this->log."Payment Method | Is Recurrence");
                    //Init Payment Process
                    $result = $service->init($order,$paymenMethod);
                }
            }

            //La subscripcion esta en "PAYMENT_PENDING y la orden esta en "Pending"
            if($isRecurrence==false)
                $this->generatePaymentLink($order);
            
        }else{
            \Log::error($this->log."ERROR|Payment Method Id not found| PaymentMethodId: ".$order->payment_code);
        }

    }

    /**
     * Generate link to payment
     */
    public function generatePaymentLink($order)
    {

        \Log::info($this->log."generatePaymentLink");

        $ec = base64_encode($order->id);
        $link = route('icommerce.payment.order',['encrip'=>$ec]);

        //Set data to notification
        $customer = $order->customer;
        $to['email'] = $customer->email;
        $to['broadcast'] = $customer->id;

        $push = [
            "title" => trans("icommerce::orders.title.paymentLink",["orderId" => $order->id]),
            "message" => trans("icommerce::orders.messages.paymentLink"),
            "icon_class" => "fa fa-bell",
            "link" => $link,
            "options" => [ 
                'linkLabel' => trans("icommerce::orders.button.pay")
            ],
            "userId" => \Auth::id() ?? null,
            "source" => "iadmin",
            "setting" => ["saveInDatabase" => 1]
        ];

        //Send Notification
        $this->notificationService->to($to)->push($push);


    }

}