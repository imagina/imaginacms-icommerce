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
  public function update($model, $data)
  {
    $this->clearCache();
    
    return $this->repository->update($model, $data);
  }
  
  /**
   * destroy a resource
   *
   * @return mixed
   */
  public function destroy($model)
  {
    $this->clearCache();
    
    return $this->repository->destroy($model);
  }
  
}
