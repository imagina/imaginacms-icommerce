<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\SubscriptionRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheSubscriptionDecorator extends BaseCacheCrudDecorator implements SubscriptionRepository
{
    public function __construct(SubscriptionRepository $subscription)
    {
        parent::__construct();
        $this->entityName = 'icommerce.subscriptions';
        $this->repository = $subscription;
    }
}
