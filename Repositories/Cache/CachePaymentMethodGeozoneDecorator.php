<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Core\Repositories\Cache\BaseCacheDecorator;
use Modules\Icommerce\Repositories\PaymentMethodGeozoneRepository;

class CachePaymentMethodGeozoneDecorator extends BaseCacheDecorator implements PaymentMethodGeozoneRepository
{
    public function __construct(PaymentMethodGeozoneRepository $paymentmethodgeozone)
    {
        parent::__construct();
        $this->entityName = 'icommerce.paymentmethodgeozones';
        $this->repository = $paymentmethodgeozone;
    }
}
