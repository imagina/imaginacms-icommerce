<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\SubscriptionStatusHistoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheSubscriptionStatusHistoryDecorator extends BaseCacheCrudDecorator implements SubscriptionStatusHistoryRepository
{
    public function __construct(SubscriptionStatusHistoryRepository $subscriptionstatushistory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.subscriptionstatushistories';
        $this->repository = $subscriptionstatushistory;
    }
}
