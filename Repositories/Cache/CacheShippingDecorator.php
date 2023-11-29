<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ShippingRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheShippingDecorator extends BaseCacheDecorator implements ShippingRepository
{
    public function __construct(ShippingRepository $shipping)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shippings';
        $this->repository = $shipping;
    }
}
