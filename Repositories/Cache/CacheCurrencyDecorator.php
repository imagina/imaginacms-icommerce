<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\CurrencyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCurrencyDecorator extends BaseCacheDecorator implements CurrencyRepository
{
  public function __construct(CurrencyRepository $currency)
  {
    parent::__construct();
    $this->entityName = 'icommerce.currencies';
    $this->repository = $currency;
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
   * get Currency Active
   *
   * @return mixed
   */
  public function getActive(){

    return $this->remember(function () {
      return $this->repository->getActive();
    });

  }

  
}
