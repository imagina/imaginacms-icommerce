<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheShippingMethodDecorator extends BaseCacheCrudDecorator implements ShippingMethodRepository
{
  public function __construct(ShippingMethodRepository $shippingmethod)
  {
    parent::__construct();
    $this->entityName = 'icommerce.shippingmethods';
    $this->repository = $shippingmethod;
  }
  
  
  public function getCalculations($request, $params)
  {
   
      return $this->repository->getCalculations($request, $params);
  
  }
}
