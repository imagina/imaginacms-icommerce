<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CartRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCartDecorator extends BaseCacheCrudDecorator implements CartRepository
{
    public function __construct(CartRepository $cart)
    {
        parent::__construct();
        $this->entityName = 'icommerce.carts';
        $this->repository = $cart;
    }
}
