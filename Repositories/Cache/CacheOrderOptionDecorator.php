<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\OrderOptionRepository;

class CacheOrderOptionDecorator extends BaseCacheDecorator implements OrderOptionRepository
{
    public function __construct(OrderOptionRepository $orderoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderoptions';
        $this->repository = $orderoption;
    }
}
