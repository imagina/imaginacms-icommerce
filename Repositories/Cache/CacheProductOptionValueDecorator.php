<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductOptionValueRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductOptionValueDecorator extends BaseCacheDecorator implements ProductOptionValueRepository
{
    public function __construct(ProductOptionValueRepository $productoptionvalue)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productoptionvalues';
        $this->repository = $productoptionvalue;
    }
}
