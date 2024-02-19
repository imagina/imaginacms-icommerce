<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductWarehouseRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheProductWarehouseDecorator extends BaseCacheCrudDecorator implements ProductWarehouseRepository
{
    public function __construct(ProductWarehouseRepository $productwarehouse)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productwarehouses';
        $this->repository = $productwarehouse;
    }
}
