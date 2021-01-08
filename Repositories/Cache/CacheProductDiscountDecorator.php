<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductDiscountRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductDiscountDecorator extends BaseCacheDecorator implements ProductDiscountRepository
{
    public function __construct(ProductDiscountRepository $productdiscount)
    {
        parent::__construct();
        $this->entityName = 'icommerce.productdiscounts';
        $this->repository = $productdiscount;
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
