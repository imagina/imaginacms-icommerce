<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Icommerce\Events\CreateProductable;
use Modules\Icommerce\Events\DeleteProductable;
use Modules\Icommerce\Events\Handlers\HandleProductable;
use Modules\Icommerce\Events\Handlers\SendOrder;
use Modules\Icommerce\Events\Handlers\SaveOrderItems;
use Modules\Icommerce\Events\Handlers\DiscountStockProducts;
use Modules\Icommerce\Events\Handlers\UpdateOrderStatus;
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Events\OrderWasUpdated;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;
use Modules\Icommerce\Events\ProductWasCreated;
use Modules\Icommerce\Events\ProductWasUpdated;
use Modules\Icommerce\Events\UpdateProductable;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderWasCreated::class => [
            SaveOrderItems::class,
            SendOrder::class
        ],
        OrderWasUpdated::class => [
            SendOrder::class
        ],
        OrderStatusHistoryWasCreated::class => [
            UpdateOrderStatus::class,
        ],
        ProductWasCreated::class => [
        ],
        ProductWasUpdated::class => [
        ],
        CreateProductable::class => [
           HandleProductable::class
        ],
        UpdateProductable::class => [
            HandleProductable::class
        ],
        DeleteProductable::class => [
            HandleProductable::class
        ],
    ];
}
