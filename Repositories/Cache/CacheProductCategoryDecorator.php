<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductCategoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheProductCategoryDecorator extends BaseCacheCrudDecorator implements ProductCategoryRepository
{
    public function __construct(ProductCategoryRepository $productcategory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productcategories';
        $this->repository = $productcategory;
    }
}
