<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\ShippingMethodGeozoneRepository;

class CacheShippingMethodGeozoneDecorator extends BaseCacheDecorator implements ShippingMethodGeozoneRepository
{
    public function __construct(ShippingMethodGeozoneRepository $shippingmethodgeozone)
    {
        parent::__construct();
        $this->entityName = 'icommerce.shippingmethodgeozones';
        $this->repository = $shippingmethodgeozone;
    }
}
