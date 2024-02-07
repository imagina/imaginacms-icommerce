<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CachePaymentMethodDecorator extends BaseCacheCrudDecorator implements PaymentMethodRepository
{
    public function __construct(PaymentMethodRepository $paymentmethod)
    {
        parent::__construct();
        $this->entityName = 'icommerce.paymentmethods';
        $this->repository = $paymentmethod;
    }
    
    public function getCalculations($params)
    {
  
      return $this->remember(function () use ($params) {
        return $this->repository->getCalculations($params);
      },$this->createKey("calculations", $params));
    }
  
}
