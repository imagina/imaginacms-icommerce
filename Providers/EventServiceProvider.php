<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

use Modules\Icommerce\Events\CreateProductable;
use Modules\Icommerce\Events\DeleteProductable;
use Modules\Icommerce\Events\Handlers\CreateChatByOrder;
use Modules\Icommerce\Events\Handlers\CreateSubOrders;
use Modules\Icommerce\Events\Handlers\HandleProductable;
use Modules\Icommerce\Events\Handlers\SendOrder;
use Modules\Icommerce\Events\Handlers\SaveOrderItems;
use Modules\Icommerce\Events\Handlers\DiscountStockProducts;
use Modules\Icommerce\Events\Handlers\UpdateOrderStatus;
use Modules\Icommerce\Events\Handlers\SavePoints;
use Modules\Icommerce\Events\Handlers\UpdateSubOrdersStatus;
use Modules\Icommerce\Events\Handlers\ValidateProductQuantityWarehouse;
use Modules\Icommerce\Events\Handlers\ValidateQuantities;
use Modules\Icommerce\Events\Handlers\ValidateQuantitiesWarehouse;
use Modules\Icommerce\Events\OrderIsCreating;
use Modules\Icommerce\Events\OrderWasCreated;
use Modules\Icommerce\Events\OrderWasUpdated;
use Modules\Icommerce\Events\OrderStatusHistoryWasCreated;
use Modules\Icommerce\Events\OrderWasProcessed;
use Modules\Icommerce\Events\ProductOptionValueWarehouseWasCreated;
use Modules\Icommerce\Events\ProductOptionValueWarehouseWasUpdated;
use Modules\Icommerce\Events\ProductOptionValueWasUpdated;
use Modules\Icommerce\Events\ProductWarehouseWasUpdated;
use Modules\Icommerce\Events\ProductWasCreated;
use Modules\Icommerce\Events\ProductWasUpdated;
use Modules\Icommerce\Events\UpdateProductable;
use Modules\Icommerce\Events\ProductOptionValueWasCreated;
use Modules\Icommerce\Events\CouponWasCreated;
use Modules\Icommerce\Events\CouponWasUpdated;
use Modules\Icommerce\Events\CouponIsDeleting;
use Modules\Icommerce\Events\Handlers\HandleCouponable;

use Modules\Icommerce\Events\FormIsCreating;
use Modules\Icommerce\Events\Handlers\Forms\LetMeKnowProductIsAvailable;
use Modules\Icommerce\Events\Handlers\Forms\Quote;

// Isite Events
use Modules\Isite\Events\OrganizationWasCreated;

class EventServiceProvider extends ServiceProvider
{
  protected $listen = [
    OrderIsCreating::class => [
      SaveOrderItems::class
    ],
    OrderWasCreated::class => [
      //SaveOrderItems::class,
      SendOrder::class,
      CreateChatByOrder::class,
      CreateSubOrders::class
    ],
    OrderWasUpdated::class => [
      SendOrder::class,

    ],
    OrderStatusHistoryWasCreated::class => [
      UpdateOrderStatus::class,
      UpdateSubOrdersStatus::class,
    ],
    OrderWasProcessed::class => [
      SavePoints::class,

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
    CouponWasCreated::class => [
      HandleCouponable::class
    ],
    CouponWasUpdated::class => [
      HandleCouponable::class
    ],
    CouponIsDeleting::class => [
      HandleCouponable::class
    ],
    FormIsCreating::class => [
      LetMeKnowProductIsAvailable::class,
      Quote::class
    ],
    OrganizationWasCreated::class => [
      LetMeKnowProductIsAvailable::class,
      Quote::class
    ],
    ProductOptionValueWasCreated::class => [
      ValidateQuantities::class,
    ],
    ProductOptionValueWasUpdated::class => [
      ValidateQuantities::class,
    ],
    ProductOptionValueWarehouseWasCreated::class => [
      ValidateQuantitiesWarehouse::class,
    ],
    ProductOptionValueWarehouseWasUpdated::class => [
      ValidateQuantitiesWarehouse::class,
    ],
    ProductWarehouseWasUpdated::class => [
      ValidateProductQuantityWarehouse::class,
    ],
    ProductWarehouseWasCreated::class => [
      ValidateProductQuantityWarehouse::class,
    ],
  ];
}
