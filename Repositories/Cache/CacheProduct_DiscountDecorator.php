<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Product_DiscountRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProduct_DiscountDecorator extends BaseCacheDecorator implements Product_DiscountRepository
{
    public function __construct(Product_DiscountRepository $product_discount)
    {
        parent::__construct();
        $this->entityName = 'icommerce.product_discounts';
        $this->repository = $product_discount;
    }
}
