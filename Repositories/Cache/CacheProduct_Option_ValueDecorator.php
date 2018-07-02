<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Product_Option_ValueRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProduct_Option_ValueDecorator extends BaseCacheDecorator implements Product_Option_ValueRepository
{
    public function __construct(Product_Option_ValueRepository $product_option_value)
    {
        parent::__construct();
        $this->entityName = 'icommerce.product_option_values';
        $this->repository = $product_option_value;
    }

     * @param  number $id
     * @return mixed
     */
    public function findByOptionValueId($id) {
        return $this->cache
            ->tags([$this->entityName, 'global'])
            ->remember("{$this->locale}.{$this->entityName}.findByOptionValueId.{$id}", $this->cacheTime,
                function () use ($id) {
                    return $this->repository->findByOptionValueId($id);
                }
            );
    } 
}
