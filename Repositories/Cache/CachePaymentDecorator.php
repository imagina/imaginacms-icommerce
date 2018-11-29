<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\PaymentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CachePaymentDecorator extends BaseCacheDecorator implements PaymentRepository
{
    public function __construct(PaymentRepository $payment)
    {
        parent::__construct();
        $this->entityName = 'icommerce.payments';
        $this->repository = $payment;
    }
}
