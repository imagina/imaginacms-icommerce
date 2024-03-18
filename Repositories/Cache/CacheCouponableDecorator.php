<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CouponableRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCouponableDecorator extends BaseCacheCrudDecorator implements CouponableRepository
{
    public function __construct(CouponableRepository $couponable)
    {
        parent::__construct();
        $this->entityName = 'icommerce.couponables';
        $this->repository = $couponable;
    }
}
