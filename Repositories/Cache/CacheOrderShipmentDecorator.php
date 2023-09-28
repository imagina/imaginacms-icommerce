<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\OrderShipmentRepository;

class CacheOrderShipmentDecorator extends BaseCacheDecorator implements OrderShipmentRepository
{
    public function __construct(OrderShipmentRepository $ordershipment)
    {
        parent::__construct();
        $this->entityName = 'icommerce.ordershipments';
        $this->repository = $ordershipment;
    }
}
