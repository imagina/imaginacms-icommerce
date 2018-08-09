<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TaxClassRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTaxClassDecorator extends BaseCacheDecorator implements TaxClassRepository
{
    public function __construct(TaxClassRepository $taxclass)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxclasses';
        $this->repository = $taxclass;
    }
}
