<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Order_ProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrder_ProductDecorator extends BaseCacheDecorator implements Order_ProductRepository
{
    public function __construct(Order_ProductRepository $order_product)
    {
        parent::__construct();
        $this->entityName = 'icommerce.order_products';
        $this->repository = $order_product;
    }
}
