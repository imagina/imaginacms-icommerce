<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Coupon_ProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCoupon_ProductDecorator extends BaseCacheDecorator implements Coupon_ProductRepository
{
    public function __construct(Coupon_ProductRepository $coupon_product)
    {
        parent::__construct();
        $this->entityName = 'icommerce.coupon_products';
        $this->repository = $coupon_product;
    }
}
