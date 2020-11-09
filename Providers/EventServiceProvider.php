<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Icommerce\Events\Handlers\SendOrder;
use Modules\Icommerce\Events\Handlers\SaveOrderItems;
use Modules\Icommerce\Events\Handlers\DiscountStockProducts;
use Modules\Icommerce\Events\Handlers\UpdateOrderStatus;
use Modules\Icommerce\Events\Handlers\UpdatePriceProductLists;
use Modules\Icommerce\Events\Handlers\RefreshProductPriceLists;
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Events\OrderWasUpdated;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;
use Modules\Icommerce\Events\ProductListWasCreated;
use Modules\Icommerce\Events\ProductWasCreated;
use Modules\Icommerce\Events\ProductWasUpdated;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderWasCreated::class => [
            SaveOrderItems::class,
            SendOrder::class
        ],
        OrderWasUpdated::class => [
            SendOrder::class,
            DiscountStockProducts::class
        ],
        OrderStatusHistoryWasCreated::class => [
            UpdateOrderStatus::class,
        ],
        ProductListWasCreated::class => [
            UpdatePriceProductLists::class,
        ],
        ProductWasCreated::class => [
            RefreshProductPriceLists::class,
        ],
        ProductWasUpdated::class => [
            RefreshProductPriceLists::class,
        ],

    ];
}
