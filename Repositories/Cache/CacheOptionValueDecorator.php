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
}
