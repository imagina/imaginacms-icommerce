<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\CouponRepository;

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
     */
    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    /**
     * find a resource by id or slug
     */
    public function getItem($criteria, $params = false)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }
}
