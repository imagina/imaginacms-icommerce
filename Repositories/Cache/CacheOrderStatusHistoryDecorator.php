<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderStatusHistoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrderStatusHistoryDecorator extends BaseCacheCrudDecorator implements OrderStatusHistoryRepository
{
    public function __construct(OrderStatusHistoryRepository $orderstatushistory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderstatushistories';
        $this->repository = $orderstatushistory;
    }
}
