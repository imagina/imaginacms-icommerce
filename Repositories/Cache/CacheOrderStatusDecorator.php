<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderStatusRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderStatusDecorator extends BaseCacheDecorator implements OrderStatusRepository
{
    public function __construct(OrderStatusRepository $orderstatus)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderstatuses';
        $this->repository = $orderstatus;
    }
}
