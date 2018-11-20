<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\WishlistRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheWishlistDecorator extends BaseCacheDecorator implements WishlistRepository
{
    public function __construct(WishlistRepository $wishlist)
    {
        parent::__construct();
        $this->entityName = 'icommerce.wishlists';
        $this->repository = $wishlist;
    }
}
