<?php

namespace Modules\Icommerce\Services;

use Modules\Icommerce\Entities\Product;

class PaymentMethodService
{
    
    private $paymentMethodRepository;
    private $fieldRepository;

    public function __construct()
    {

       $this->paymentMethodRepository = app('Modules\Icommerce\Repositories\PaymentMethodRepository');
       $this->fieldRepository = app("Modules\Iprofile\Repositories\FieldRepository");

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

}