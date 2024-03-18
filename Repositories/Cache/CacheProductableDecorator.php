<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductableRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheProductableDecorator extends BaseCacheCrudDecorator implements ProductableRepository
{
    public function __construct(ProductableRepository $productable)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productables';
        $this->repository = $productable;
    }
}
