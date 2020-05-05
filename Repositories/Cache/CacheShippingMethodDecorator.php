<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheShippingMethodDecorator extends BaseCacheDecorator implements ShippingMethodRepository
{
    public function __construct(ShippingMethodRepository $shippingmethod)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shippingmethods';
        $this->repository = $shippingmethod;
    }

    
  /**
   * List or resources
   *
   * @return collection
   */
  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }
  
  /**
   * find a resource by id or slug
   *
   * @return object
   */
  public function getItem($criteria, $params)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }

    public function getCalculations($request, $params)
    {
        return $this->remember(function () use ($request, $params) {
            return $this->repository->getCalculations($request, $params);
        });
    }
}
