<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderShipmentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderShipmentDecorator extends BaseCacheDecorator implements OrderShipmentRepository
{
    public function __construct(OrderShipmentRepository $ordershipment)
    {
        parent::__construct();
        $this->entityName = 'icommerce.ordershipments';
        $this->repository = $ordershipment;
    }
}
