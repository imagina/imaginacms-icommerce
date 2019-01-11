<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Icommerce\Events\Handlers\SendOrder;
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Events\OrderWasUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderWasCreated::class => [
            SendOrder::class,
        ],
        OrderWasUpdated::class => [
            SendOrder::class,
        ],
      
    ];
}
