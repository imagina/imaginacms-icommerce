<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\ProductRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProductDecorator extends BaseCacheDecorator implements ProductRepository
{
    /**
     * @var ProductRepository
     */
    protected $repository;

    public function __construct(ProductRepository $product)
    {
        parent::__construct();
        $this->entityName = 'icommerce.products';
        $this->repository = $product;
    }

    /**
     * @return mixed
     */
    public function all() {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.all", $this->cacheTime,
                function (){
                    return $this->repository->all();
                }
            );
    }

    /**
     * @param  number $id
     * @return mixed
     */
    public function find($id) {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.find.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->find($id);
                }
            );
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName($name,$filter,$type) {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findByName.{$name}", $this->cacheTime,
                function () use ($name) {
                    return $this->repository->findByName($name);
                }
            );
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function whereCategory($id)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.whereCategory.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->whereCategory($id);
                }
            );
    }

    /**
     * @param string $slug
     * @return mixed
     */
    public function findBySlug($slug)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findBySlug.{$slug}", $this->cacheTime,
                function () use ($slug) {
                    return $this->repository->findBySlug($slug);
                }
            );
    }

    /**
     * @return mixed
     */
    public function whereFeaturedProducts($id)
    {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findBySlug.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->whereFeaturedProducts($id);
                }
            );
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function whereParentId($id)
    {
        // TODO: Implement whereParentId() method.
    }
  public function whereCategoryFilter($id,$filter,$type){
    return $this->repository->whereCategoryFilter($id,$filter,$type);
  }
  
  /**
   * @return mixed
   */
  public function whereFreeshippingProducts(){
      return $this->repository->whereFreeshippingProducts();
  }
  public function whereFreeshippingProductsFilter($filter){
      return $this->repository->whereFreeshippingProductsFilter($filter);
  }
}
