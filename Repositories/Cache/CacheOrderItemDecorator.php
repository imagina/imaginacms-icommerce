<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderItemRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrderItemDecorator extends BaseCacheCrudDecorator implements OrderItemRepository
{
    public function __construct(OrderItemRepository $orderitem)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderitems';
        $this->repository = $orderitem;
    }
}
