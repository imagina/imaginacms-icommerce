<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Coupon_CategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCoupon_CategoryDecorator extends BaseCacheDecorator implements Coupon_CategoryRepository
{
    public function __construct(Coupon_CategoryRepository $coupon_category)
    {
        parent::__construct();
        $this->entityName = 'icommerce.coupon_categories';
        $this->repository = $coupon_category;
    }
}
