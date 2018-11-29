<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OptionRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheOptionDecorator extends BaseCacheDecorator implements OptionRepository
{
    public function __construct(OptionRepository $option)
    {
        parent::__construct();
        $this->entityName = 'icommerce.options';
        $this->repository = $option;
    }
}
