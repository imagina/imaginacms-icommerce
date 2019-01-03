<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CartProductOptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCartProductOptionDecorator extends BaseCacheDecorator implements CartProductOptionRepository
{
    public function __construct(CartProductOptionRepository $cartproductoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.cartproductoptions';
        $this->repository = $cartproductoption;
    }
}
