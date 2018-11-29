<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CartRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCartDecorator extends BaseCacheDecorator implements CartRepository
{
    public function __construct(CartRepository $cart)
    {
        parent::__construct();
        $this->entityName = 'icommerce.carts';
        $this->repository = $cart;
    }
}
