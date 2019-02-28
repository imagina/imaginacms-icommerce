<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ShippingMethodGeozoneRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheShippingMethodGeozoneDecorator extends BaseCacheDecorator implements ShippingMethodGeozoneRepository
{
    public function __construct(ShippingMethodGeozoneRepository $shippingmethodgeozone)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shippingmethodgeozones';
        $this->repository = $shippingmethodgeozone;
    }
}
