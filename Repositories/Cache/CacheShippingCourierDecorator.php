<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ShippingCourierRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheShippingCourierDecorator extends BaseCacheDecorator implements ShippingCourierRepository
{
    public function __construct(ShippingCourierRepository $shippingcourier)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shippingcouriers';
        $this->repository = $shippingcourier;
    }
}
