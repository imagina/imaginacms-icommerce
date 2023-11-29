<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CouponCategoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCouponCategoryDecorator extends BaseCacheDecorator implements CouponCategoryRepository
{
    public function __construct(CouponCategoryRepository $couponcategory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.couponcategories';
        $this->repository = $couponcategory;
    }
}
