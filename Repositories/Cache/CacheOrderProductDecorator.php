<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderProductDecorator extends BaseCacheDecorator implements OrderProductRepository
{
    public function __construct(OrderProductRepository $orderproduct)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderproducts';
        $this->repository = $orderproduct;
    }
}
