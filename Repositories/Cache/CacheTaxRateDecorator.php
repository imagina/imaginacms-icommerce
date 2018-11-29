<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TaxRateRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTaxRateDecorator extends BaseCacheDecorator implements TaxRateRepository
{
    public function __construct(TaxRateRepository $taxrate)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxrates';
        $this->repository = $taxrate;
    }
}
