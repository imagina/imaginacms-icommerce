<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CouponHistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCouponHistoryDecorator extends BaseCacheDecorator implements CouponHistoryRepository
{
    public function __construct(CouponHistoryRepository $couponhistory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.couponhistories';
        $this->repository = $couponhistory;
    }
}
