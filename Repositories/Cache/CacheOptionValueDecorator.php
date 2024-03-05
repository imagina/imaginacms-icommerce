<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\OptionValueRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CacheOptionValueDecorator extends BaseCacheCrudDecorator implements OptionValueRepository
{
    public function __construct(OptionValueRepository $optionvalue)
    {
        parent::__construct();
        $this->entityName = 'icommerce.optionvalues';
        $this->repository = $optionvalue;
    }
}
