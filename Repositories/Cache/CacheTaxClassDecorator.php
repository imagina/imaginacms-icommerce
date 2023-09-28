<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\TaxClassRepository;

class CacheTaxClassDecorator extends BaseCacheDecorator implements TaxClassRepository
{
    public function __construct(TaxClassRepository $taxclass)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxclasses';
        $this->repository = $taxclass;
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

    /**
     * create a resource
     *
     * @return mixed
     */
    public function create($data)
    {
        $this->clearCache();

        return $this->repository->create($data);
    }
}
