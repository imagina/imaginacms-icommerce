<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TaxClassRateRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheTaxClassRateDecorator extends BaseCacheCrudDecorator implements TaxClassRateRepository
{
    public function __construct(TaxClassRateRepository $taxclassrate)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxclassrates';
        $this->repository = $taxclassrate;
    }
}
