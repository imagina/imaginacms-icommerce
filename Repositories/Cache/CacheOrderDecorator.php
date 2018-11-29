<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderDecorator extends BaseCacheDecorator implements OrderRepository
{
    public function __construct(OrderRepository $order)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orders';
        $this->repository = $order;
    }
}
