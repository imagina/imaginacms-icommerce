<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheProductDecorator extends BaseCacheCrudDecorator implements ProductRepository
{
  public function __construct(ProductRepository $product)
  {
    parent::__construct();
    $this->entityName = 'icommerce.products';
    $this->repository = $product;
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

  /**
   * Get Product Types From Products Filtered
   *
   * @return collection
   */
  public function getProductTypes($params)
  {
    return $this->remember(function () use ($params) {
      return $this->repository->getProductTypes($params);
    });
  }
}
