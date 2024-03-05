<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TaxClassRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheTaxClassDecorator extends BaseCacheCrudDecorator implements TaxClassRepository
{
    public function __construct(TaxClassRepository $taxclass)
    {
        parent::__construct();
        $this->entityName = 'icommerce.taxclasses';
        $this->repository = $taxclass;
    }
}
