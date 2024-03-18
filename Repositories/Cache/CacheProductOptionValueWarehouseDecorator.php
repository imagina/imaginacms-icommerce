<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductOptionValueWarehouseRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheProductOptionValueWarehouseDecorator extends BaseCacheCrudDecorator implements ProductOptionValueWarehouseRepository
{
    public function __construct(ProductOptionValueWarehouseRepository $productoptionvaluewarehouse)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productoptionvaluewarehouses';
        $this->repository = $productoptionvaluewarehouse;
    }
}
