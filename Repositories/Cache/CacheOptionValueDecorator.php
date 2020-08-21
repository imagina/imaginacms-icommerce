<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OptionValueRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOptionValueDecorator extends BaseCacheDecorator implements OptionValueRepository
{
  public function __construct(OptionValueRepository $optionvalue)
  {
    parent::__construct();
    $this->entityName = 'icommerce.optionvalues';
    $this->repository = $optionvalue;
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
