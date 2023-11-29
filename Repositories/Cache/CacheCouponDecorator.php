<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CouponRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCouponDecorator extends BaseCacheDecorator implements CouponRepository
{
  public function __construct(CouponRepository $coupon)
  {
    parent::__construct();
    $this->entityName = 'icommerce.coupons';
    $this->repository = $coupon;
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
  public function getItem($criteria, $params = false)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }
  

  
}
