<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TaxRatesRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTaxRatesDecorator extends BaseCacheDecorator implements TaxRatesRepository
{
    public function __construct(TaxRatesRepository $taxrates)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxrates';
        $this->repository = $taxrates;
    }
}
