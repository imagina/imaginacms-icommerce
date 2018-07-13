<?php

namespace Modules\Icommerce\Repositories\Eloquent;

use Modules\Icommerce\Repositories\PaymentRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;

class EloquentPaymentRepository extends EloquentBaseRepository implements PaymentRepository
{

	public function getPaymentsMethods()
    {
        
    	$paymentMethods = config('asgard.icommerce.config.paymentmethods');
    	$fixCollect = collect([]);
    	$resultMethods = collect([]);

    	if(isset($paymentMethods) && count($paymentMethods)>0){
    		foreach ($paymentMethods as $key => $method) {

    			$methodConfiguration = null;
                try{
                    //$methodConfiguration = $method['entity']::query()->select("description","options","status")->first();
                    $methodConfiguration = new $method['entity'];
                    $methodConfiguration = $methodConfiguration->getData();
                }
                catch(\Exception $e){
                   $methodConfiguration = null; 
                }

                if($methodConfiguration != null && $methodConfiguration->status==1){
                    
                    $methodConfiguration->configName = $method['name'];
                    $methodConfiguration->configTitle =trans($method['title']);

                    $resultMethods->push($methodConfiguration);
                }
    		}
    	}

    	if(count($paymentMethods)==0 || ($resultMethods->count())==0)
    		$resultMethods = null;

    	return $resultMethods;
    }


}
