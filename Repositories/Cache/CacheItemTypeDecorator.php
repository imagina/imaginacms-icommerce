<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ItemTypeRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheItemTypeDecorator extends BaseCacheDecorator implements ItemTypeRepository
{
    public function __construct(ItemTypeRepository $itemtype)
    {
        parent::__construct();
        $this->entityName = 'icommerce.itemtypes';
        $this->repository = $itemtype;
    }
}
