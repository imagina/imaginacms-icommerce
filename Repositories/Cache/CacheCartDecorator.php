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
     * @param $criteria
     * @param $params
     * @return object
     */
  public function getItem($criteria, $params=false)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
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
  public function updateBy($criteria, $data, $params = false)
  {
    $this->clearCache();
    
    return $this->repository->updateBy($criteria, $data, $params);
  }
  
  /**
   * destroy a resource
   *
   * @return mixed
   */
  public function deleteBy($criteria, $params = false)
  {
    $this->clearCache();
    
    return $this->repository->deleteBy($criteria, $params);
  }
  
}
