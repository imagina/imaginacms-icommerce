<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheManufacturerDecorator extends BaseCacheCrudDecorator implements ManufacturerRepository
{
    public function __construct(ManufacturerRepository $manufacturer)
    {
        parent::__construct();
        $this->entityName = 'icommerce.manufacturers';
        $this->repository = $manufacturer;
    }
}
