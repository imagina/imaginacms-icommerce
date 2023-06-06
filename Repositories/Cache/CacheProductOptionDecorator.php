<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductOptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductOptionDecorator extends BaseCacheDecorator implements ProductOptionRepository
{
    public function __construct(ProductOptionRepository $productoption)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productoptions';
        $this->repository = $productoption;
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
