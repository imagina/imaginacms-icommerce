<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductTagRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductTagDecorator extends BaseCacheDecorator implements ProductTagRepository
{
    public function __construct(ProductTagRepository $producttag)
    {
        parent::__construct();
        $this->entityName = 'icommerce.producttags';
        $this->repository = $producttag;
    }
}
