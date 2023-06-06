<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductDecorator extends BaseCacheDecorator implements ProductRepository
{
  public function __construct(ProductRepository $product)
  {
    parent::__construct();
    $this->entityName = 'icommerce.products';
    $this->repository = $product;
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
  
  /**
   * Min and Max Price
   *
   * @return collection
   */
  public function getPriceRange($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getPriceRange($params);
    });
  }

  /**
   * Get Manufactures From Products Filtered
   *
   * @return collection
   */
  public function getManufacturers($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getManufacturers($params);
    });
  }

  /**
   * Get Product Options From Products Filtered
   *
   * @return collection
   */
  public function getProductOptions($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getProductOptions($params);
    });
  }

}
