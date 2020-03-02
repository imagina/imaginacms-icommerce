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
  
  /**
   * List or resources
   *
   * @return collection
   */
  public function getItemsBy($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getItemsBy($params);
    });
  }
  
  /**
   * find a resource by id or slug
   *
   * @return object
   */
  public function getItem($criteria, $params)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }

  
}
