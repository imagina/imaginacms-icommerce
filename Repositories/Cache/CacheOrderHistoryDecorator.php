<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OrderHistoryRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOrderHistoryDecorator extends BaseCacheDecorator implements OrderHistoryRepository
{
  public function __construct(OrderHistoryRepository $orderhistory)
  {
    parent::__construct();
    $this->entityName = 'icommerce.orderhistories';
    $this->repository = $orderhistory;
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
