<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\ProductCategoryRepository;

class CacheProductCategoryDecorator extends BaseCacheDecorator implements ProductCategoryRepository
{
    public function __construct(ProductCategoryRepository $productcategory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productcategories';
        $this->repository = $productcategory;
    }
}
