<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductDiscountRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductDiscountDecorator extends BaseCacheDecorator implements ProductDiscountRepository
{
    public function __construct(ProductDiscountRepository $productdiscount)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productdiscounts';
        $this->repository = $productdiscount;
    }
}
