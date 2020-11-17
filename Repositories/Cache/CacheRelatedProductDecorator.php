<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\RelatedProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheRelatedProductDecorator extends BaseCacheDecorator implements RelatedProductRepository
{
    public function __construct(RelatedProductRepository $relatedproduct)
    {
        parent::__construct();
        $this->entityName = 'icommerce.relatedproducts';
        $this->repository = $relatedproduct;
    }
}
