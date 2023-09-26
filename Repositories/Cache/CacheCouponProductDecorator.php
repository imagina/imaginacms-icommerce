<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\CouponProductRepository;

class CacheCouponProductDecorator extends BaseCacheDecorator implements CouponProductRepository
{
    public function __construct(CouponProductRepository $couponproduct)
    {
        parent::__construct();
        $this->entityName = 'icommerce.couponproducts';
        $this->repository = $couponproduct;
    }
}
