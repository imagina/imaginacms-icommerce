<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CartProductOptionRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheCartProductOptionDecorator extends BaseCacheCrudDecorator implements CartProductOptionRepository
{
    public function __construct(CartProductOptionRepository $cartproductoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.cartproductoptions';
        $this->repository = $cartproductoption;
    }
}
