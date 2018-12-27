<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\TagRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTagDecorator extends BaseCacheDecorator implements TagRepository
{
  public function __construct(TagRepository $tag)
  {
    parent::__construct();
    $this->entityName = 'icommerce.tags';
    $this->repository = $tag;
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
