<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\ItemTypeRepository;

class CacheItemTypeDecorator extends BaseCacheDecorator implements ItemTypeRepository
{
    public function __construct(ItemTypeRepository $itemtype)
    {
        parent::__construct();
        $this->entityName = 'icommerce.itemtypes';
        $this->repository = $itemtype;
    }
}
