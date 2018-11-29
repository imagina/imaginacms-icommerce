<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderHistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderHistoryDecorator extends BaseCacheDecorator implements OrderHistoryRepository
{
    public function __construct(OrderHistoryRepository $orderhistory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderhistories';
        $this->repository = $orderhistory;
    }
}
