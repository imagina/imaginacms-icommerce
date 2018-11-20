<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Coupon_HistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCoupon_HistoryDecorator extends BaseCacheDecorator implements Coupon_HistoryRepository
{
    public function __construct(Coupon_HistoryRepository $coupon_history)
    {
        parent::__construct();
        $this->entityName = 'icommerce.coupon_histories';
        $this->repository = $coupon_history;
    }
}
