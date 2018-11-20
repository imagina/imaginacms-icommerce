<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\AddressRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheAddressDecorator extends BaseCacheDecorator implements AddressRepository
{
    public function __construct(AddressRepository $address)
    {
        parent::__construct();
        $this->entityName = 'icommerce.addresses';
        $this->repository = $address;
    }
}
