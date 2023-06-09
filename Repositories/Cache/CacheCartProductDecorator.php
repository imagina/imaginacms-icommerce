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
  public function getItem($criteria, $params = false)
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
 
    $this->clearCache('icommerce.carts');
    
    return $this->repository->create($data);
  }
  
  /**
   * update a resource
   *
   * @return mixed
   */
  public function updateBy($criteria, $data, $params = false)
  {
    $this->clearCache('icommerce.carts');
    
    return $this->repository->updateBy($criteria, $data, $params);
  }

  /**
   * destroy a resource
   *
   * @return mixed
   */
  public function deleteBy($criteria, $params = false)
  {
    $this->clearCache('icommerce.carts');
    
    return $this->repository->deleteBy($criteria, $params);
  }

}
