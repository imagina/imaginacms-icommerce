<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\Product_OptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheProduct_OptionDecorator extends BaseCacheDecorator implements Product_OptionRepository
{
    public function __construct(Product_OptionRepository $product_option)
    {
        parent::__construct();
        $this->entityName = 'icommerce.product_options';
        $this->repository = $product_option;
    }
}
