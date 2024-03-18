<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CouponOrderHistoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCouponOrderHistoryDecorator extends BaseCacheCrudDecorator implements CouponOrderHistoryRepository
{
    public function __construct(CouponOrderHistoryRepository $couponorderhistory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.couponorderhistories';
        $this->repository = $couponorderhistory;
    }
}
