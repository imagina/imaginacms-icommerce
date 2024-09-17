<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TaxRateRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheTaxRateDecorator extends BaseCacheCrudDecorator implements TaxRateRepository
{
    public function __construct(TaxRateRepository $taxrate)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxrates';
        $this->repository = $taxrate;
    }
}
