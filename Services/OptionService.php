<?php

namespace Modules\Icommerce\Services;

class OptionService
{
    
    private $log; 

    /**
     * Construct
     */
    public function __construct()
    {   
        $this->log = "Icommerce: Services|OptionService|";
    }

    /**
    *  Root Option or OptionValue
    */
    public function checkOptionHasGroup($criteria,$root="option")
    {

        if($root=="option"){
            //Get Option
            $params = ['include'=> []];
            $option = app('Modules\Icommerce\Repositories\OptionRepository')->getItem($criteria,json_decode(json_encode($params)));
           
        }else{
            //is from Option Value
            $params = ['include'=> []];
            $optionValue = app('Modules\Icommerce\Repositories\OptionValueRepository')->getItem($criteria,json_decode(json_encode($params)));

            //Get Option
            $option = $optionValue->option;
           
        }

        //Validation Delete
        if(!is_null($option->group) && $option->group=="payment-frequency")
            throw new \Exception('Cannot delete this record', 402);

    }


}