<?php

namespace Modules\Icommerce\Repositories\Cache;

use Modules\Icommerce\Repositories\PaymentMethodGeozoneRepository;
use Modules\Core\Icrud\Repositories\Cache\BaseCacheCrudDecorator;

class CachePaymentMethodGeozoneDecorator extends BaseCacheCrudDecorator implements PaymentMethodGeozoneRepository
{
    public function __construct(PaymentMethodGeozoneRepository $paymentmethodgeozone)
    {
        parent::__construct();
        $this->entityName = 'icommerce.paymentmethodgeozones';
        $this->repository = $paymentmethodgeozone;
    }
}
