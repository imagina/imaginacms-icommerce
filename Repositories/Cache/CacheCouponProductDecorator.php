<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CouponProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCouponProductDecorator extends BaseCacheDecorator implements CouponProductRepository
{
    public function __construct(CouponProductRepository $couponproduct)
    {
        parent::__construct();
        $this->entityName = 'icommerce.couponproducts';
        $this->repository = $couponproduct;
    }
}
