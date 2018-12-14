<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\PaymentMethodRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePaymentMethodDecorator extends BaseCacheDecorator implements PaymentMethodRepository
{
    public function __construct(PaymentMethodRepository $paymentmethod)
    {
        parent::__construct();
        $this->entityName = 'icommerce.paymentmethods';
        $this->repository = $paymentmethod;
    }
}
