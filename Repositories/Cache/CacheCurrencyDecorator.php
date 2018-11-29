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
}
