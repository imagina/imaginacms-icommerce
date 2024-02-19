<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\WarehouseRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheWarehouseDecorator extends BaseCacheCrudDecorator implements WarehouseRepository
{
    public function __construct(WarehouseRepository $warehouse)
    {
        parent::__construct();
        $this->entityName = 'icommerce.warehouses';
        $this->repository = $warehouse;
    }
}
