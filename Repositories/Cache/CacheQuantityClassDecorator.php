<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\QuantityClassRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheQuantityClassDecorator extends BaseCacheCrudDecorator implements QuantityClassRepository
{
    public function __construct(QuantityClassRepository $quantityclass)
    {
        parent::__construct();
        $this->entityName = 'icommerce.quantityclasses';
        $this->repository = $quantityclass;
    }
}
