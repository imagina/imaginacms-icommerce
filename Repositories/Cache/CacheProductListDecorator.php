<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductListRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductListDecorator extends BaseCacheDecorator implements ProductListRepository
{
    public function __construct(ProductListRepository $productlist)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productlists';
        $this->repository = $productlist;
    }
}
