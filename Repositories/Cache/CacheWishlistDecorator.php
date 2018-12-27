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
  public function index($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->index($params);
    });
  }
  
  /**
   * find a resource by id or slug
   *
   * @return object
   */
  public function show($criteria, $params)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->show($criteria, $params);
    });
  }
  
  /**
   * create a resource
   *
   * @return mixed
   */
  public function create($data)
  {
    $this->clearCache();
    
    return $this->repository->create($data);
  }
  
  /**
   * update a resource
   *
   * @return mixed
   */
  public function updateBy($criteria, $data, $params)
  {
    $this->clearCache();
    
    return $this->repository->updateBy($criteria, $data, $params);
  }
  
  /**
   * destroy a resource
   *
   * @return mixed
   */
  public function deleteBy($criteria, $params)
  {
    $this->clearCache();
    
    return $this->repository->deleteBy($criteria, $params);
  }
  
  
}
