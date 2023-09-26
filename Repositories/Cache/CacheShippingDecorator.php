<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\ShippingRepository;

class CacheShippingDecorator extends BaseCacheDecorator implements ShippingRepository
{
    public function __construct(ShippingRepository $shipping)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shippings';
        $this->repository = $shipping;
    }
}
