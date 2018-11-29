<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TaxClassRateRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTaxClassRateDecorator extends BaseCacheDecorator implements TaxClassRateRepository
{
    public function __construct(TaxClassRateRepository $taxclassrate)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxclassrates';
        $this->repository = $taxclassrate;
    }
}
