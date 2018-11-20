<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TaxClassRatesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTaxClassRatesDecorator extends BaseCacheDecorator implements TaxClassRatesRepository
{
    public function __construct(TaxClassRatesRepository $taxclassrates)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxclassrates';
        $this->repository = $taxclassrates;
    }
}
