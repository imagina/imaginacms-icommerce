<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\OrderHistoryRepository;

class CacheOrderHistoryDecorator extends BaseCacheDecorator implements OrderHistoryRepository
{
    public function __construct(OrderHistoryRepository $orderhistory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderhistories';
        $this->repository = $orderhistory;
    }

    /**
     * List or resources
     */
    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    /**
     * find a resource by id or slug
     */
    public function getItem($criteria, $params = false)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }
}
