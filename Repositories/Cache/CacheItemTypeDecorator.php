<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ItemTypeRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheItemTypeDecorator extends BaseCacheCrudDecorator implements ItemTypeRepository
{
    public function __construct(ItemTypeRepository $itemtype)
    {
        parent::__construct();
        $this->entityName = 'icommerce.itemtypes';
        $this->repository = $itemtype;
    }
}
