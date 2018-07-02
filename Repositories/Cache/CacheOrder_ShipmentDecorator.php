<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Order_ShipmentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrder_ShipmentDecorator extends BaseCacheDecorator implements Order_ShipmentRepository
{
    public function __construct(Order_ShipmentRepository $order_shipment)
    {
        parent::__construct();
        $this->entityName = 'icommerce.order_shipments';
        $this->repository = $order_shipment;
    }
}
