<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductDiscountRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheProductDiscountDecorator extends BaseCacheCrudDecorator implements ProductDiscountRepository
{
    public function __construct(ProductDiscountRepository $productdiscount)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productdiscounts';
        $this->repository = $productdiscount;
    }
}
