<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\StoreRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheStoreDecorator extends BaseCacheDecorator implements StoreRepository
{
    public function __construct(StoreRepository $stores)
    {
        parent::__construct();
        $this->entityName = 'icommerce.stores';
        $this->repository = $stores;
    }

    /**
     * List or resources
     *
     * @return collection
     */
    public function getItemsBy($params)
    {
        return $this->remember(function () use ($params) {
            return $this->repository->getItemsBy($params);
        });
    }

    /**
     * find a resource by id or slug
     *
     * @return object
     */
    public function getItem($criteria, $params)
    {
        return $this->remember(function () use ($criteria, $params) {
            return $this->repository->getItem($criteria, $params);
        });
    }

}
