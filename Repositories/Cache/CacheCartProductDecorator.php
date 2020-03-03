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
  public function getItem($criteria, $params)
  {
    return $this->remember(function () use ($criteria, $params) {
      return $this->repository->getItem($criteria, $params);
    });
  }



}
