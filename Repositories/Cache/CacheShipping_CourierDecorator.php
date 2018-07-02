<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Shipping_CourierRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheShipping_CourierDecorator extends BaseCacheDecorator implements Shipping_CourierRepository
{
    public function __construct(Shipping_CourierRepository $shipping_courier)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shipping_couriers';
        $this->repository = $shipping_courier;
    }
}
