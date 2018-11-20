<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Order_HistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrder_HistoryDecorator extends BaseCacheDecorator implements Order_HistoryRepository
{
    public function __construct(Order_HistoryRepository $order_history)
    {
        parent::__construct();
        $this->entityName = 'icommerce.order_history';
        $this->repository = $order_history;
    }
}
