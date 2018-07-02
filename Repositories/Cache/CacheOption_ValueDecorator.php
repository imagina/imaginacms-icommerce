<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Option_ValueRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOption_ValueDecorator extends BaseCacheDecorator implements Option_ValueRepository
{
    /**
     * @var ProductRepository
     */
    protected $repository;
    
    public function __construct(Option_ValueRepository $option_value)
    {
        parent::__construct();
        $this->entityName = 'icommerce.option_values';
        $this->repository = $option_value;
    }
    
     * @param  number $id
     * @return mixed
     */
    public function findById($id) {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findById.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->findById($id);
                }
            );
    }

     * @param  number $id
     * @return mixed
     */
    public function findByParentId($id) {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findByParentId.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->findByParentId($id);
                }
            );
    }    
}
