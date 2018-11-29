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
}
