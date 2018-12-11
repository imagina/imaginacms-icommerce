<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\PriceListRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePriceListDecorator extends BaseCacheDecorator implements PriceListRepository
{
    public function __construct(PriceListRepository $list)
    {
        parent::__construct();
        $this->entityName = 'icommerce.pricelists';
        $this->repository = $list;
    }
}
