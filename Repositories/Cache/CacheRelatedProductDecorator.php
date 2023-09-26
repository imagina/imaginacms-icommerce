<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\RelatedProductRepository;

class CacheRelatedProductDecorator extends BaseCacheDecorator implements RelatedProductRepository
{
    public function __construct(RelatedProductRepository $relatedproduct)
    {
        parent::__construct();
        $this->entityName = 'icommerce.relatedproducts';
        $this->repository = $relatedproduct;
    }
}
