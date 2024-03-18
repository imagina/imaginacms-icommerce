<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderOptionRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOrderOptionDecorator extends BaseCacheCrudDecorator implements OrderOptionRepository
{
    public function __construct(OrderOptionRepository $orderoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.orderoptions';
        $this->repository = $orderoption;
    }
}
