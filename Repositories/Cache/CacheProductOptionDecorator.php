<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductOptionRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheProductOptionDecorator extends BaseCacheCrudDecorator implements ProductOptionRepository
{
    public function __construct(ProductOptionRepository $productoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productoptions';
        $this->repository = $productoption;
    }
}
