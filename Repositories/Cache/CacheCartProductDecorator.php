<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCartProductDecorator extends BaseCacheDecorator implements CartProductRepository
{
    public function __construct(CartProductRepository $cartproduct)
    {
        parent::__construct();
        $this->entityName = 'icommerce.cartproducts';
        $this->repository = $cartproduct;
    }
}
