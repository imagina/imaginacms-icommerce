<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductOptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductOptionDecorator extends BaseCacheDecorator implements ProductOptionRepository
{
    public function __construct(ProductOptionRepository $productoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productoptions';
        $this->repository = $productoption;
    }
}
