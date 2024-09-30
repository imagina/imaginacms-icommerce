<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\RelatedProductRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheRelatedProductDecorator extends BaseCacheCrudDecorator implements RelatedProductRepository
{
    public function __construct(RelatedProductRepository $relatedproduct)
    {
        parent::__construct();
        $this->entityName = 'icommerce.relatedproducts';
        $this->repository = $relatedproduct;
    }
}
