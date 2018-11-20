<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Order_OptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrder_OptionDecorator extends BaseCacheDecorator implements Order_OptionRepository
{
    public function __construct(Order_OptionRepository $order_option)
    {
        parent::__construct();
        $this->entityName = 'icommerce.order_option';
        $this->repository = $order_option;
    }
}
