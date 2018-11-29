<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheManufacturerDecorator extends BaseCacheDecorator implements ManufacturerRepository
{
    public function __construct(ManufacturerRepository $manufacturer)
    {
        parent::__construct();
        $this->entityName = 'icommerce.manufacturers';
        $this->repository = $manufacturer;
    }
}
