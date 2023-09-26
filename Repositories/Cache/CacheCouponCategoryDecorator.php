<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\CouponCategoryRepository;

class CacheCouponCategoryDecorator extends BaseCacheDecorator implements CouponCategoryRepository
{
    public function __construct(CouponCategoryRepository $couponcategory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.couponcategories';
        $this->repository = $couponcategory;
    }
}
