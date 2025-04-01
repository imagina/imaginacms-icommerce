<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderStatusCategoryRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrderStatusCategoryDecorator extends BaseCacheCrudDecorator implements OrderStatusCategoryRepository
{
    public function __construct(OrderStatusCategoryRepository $orderstatuscategory)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderstatuscategories';
        $this->repository = $orderstatuscategory;
    }
}
