<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderOptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderOptionDecorator extends BaseCacheDecorator implements OrderOptionRepository
{
    public function __construct(OrderOptionRepository $orderoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderoptions';
        $this->repository = $orderoption;
    }
}
