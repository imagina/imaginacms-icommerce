<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CartProductRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCartProductDecorator extends BaseCacheCrudDecorator implements CartProductRepository
{
    public function __construct(CartProductRepository $cartproduct)
    {
        parent::__construct();
        $this->entityName = 'icommerce.cartproducts';
        $this->repository = $cartproduct;
    }
}
