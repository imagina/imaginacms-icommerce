<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ShippingMethodRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheShippingMethodDecorator extends BaseCacheDecorator implements ShippingMethodRepository
{
    public function __construct(ShippingMethodRepository $shippingmethod)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shippingmethods';
        $this->repository = $shippingmethod;
    }
}
