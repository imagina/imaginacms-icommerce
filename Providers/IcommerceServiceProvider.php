<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Icommerce\Console\UpdateCarts;
use Modules\Icommerce\Listeners\RegisterIcommerceSidebar;

class IcommerceServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterIcommerceSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            // append translations
        });


    }

    public function boot()
    {

      $this->publishConfig('icommerce', 'config');
      $this->publishConfig('icommerce', 'crud-fields');
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icommerce', 'settings'), "asgard.icommerce.settings");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icommerce', 'settings-fields'), "asgard.icommerce.settings-fields");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icommerce', 'permissions'), "asgard.icommerce.permissions");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icommerce', 'cmsPages'), "asgard.icommerce.cmsPages");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icommerce', 'cmsSidebar'), "asgard.icommerce.cmsSidebar");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icommerce', 'blocks'), "asgard.icommerce.blocks");
      $this->mergeConfigFrom($this->getModuleConfigFilePath('icommerce', 'gamification'), "asgard.icommerce.gamification");
      //$this->app[TagManager::class]->registerNamespace(new Product());
      //$this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

      $this->registerComponents();
      $this->registerComponentsLivewire();
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides()
    {
        return [];
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Icommerce\Repositories\CategoryRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Icommerce\Entities\Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ManufacturerRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentManufacturerRepository(new \Modules\Icommerce\Entities\Manufacturer());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheManufacturerDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\TaxRateRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTaxRateRepository(new \Modules\Icommerce\Entities\TaxRate());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheTaxRateDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\TaxClassRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTaxClassRepository(new \Modules\Icommerce\Entities\TaxClass());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheTaxClassDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\TaxClassRateRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTaxClassRateRepository(new \Modules\Icommerce\Entities\TaxClassRate());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheTaxClassRateDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductRepository(new \Modules\Icommerce\Entities\Product());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductCategoryRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductCategoryRepository(new \Modules\Icommerce\Entities\ProductCategory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductCategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\OptionRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOptionRepository(new \Modules\Icommerce\Entities\Option());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\CouponRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCouponRepository(new \Modules\Icommerce\Entities\Coupon());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCouponDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\CurrencyRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCurrencyRepository(new \Modules\Icommerce\Entities\Currency());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCurrencyDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\OrderStatusRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderStatusRepository(new \Modules\Icommerce\Entities\OrderStatus());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrderStatusDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\OrderRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderRepository(new \Modules\Icommerce\Entities\Order());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrderDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\OptionValueRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOptionValueRepository(new \Modules\Icommerce\Entities\OptionValue());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOptionValueDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductOptionRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductOptionRepository(new \Modules\Icommerce\Entities\ProductOption());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductOptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductDiscountRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductDiscountRepository(new \Modules\Icommerce\Entities\ProductDiscount());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductDiscountDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ItemTypeRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentItemTypeRepository(new \Modules\Icommerce\Entities\ItemType());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheItemTypeDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\OrderItemRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderItemRepository(new \Modules\Icommerce\Entities\OrderItem());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrderItemDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\OrderOptionRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderOptionRepository(new \Modules\Icommerce\Entities\OrderOption());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrderOptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\OrderStatusHistoryRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderStatusHistoryRepository(new \Modules\Icommerce\Entities\OrderStatusHistory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrderStatusHistoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\CouponOrderHistoryRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCouponOrderHistoryRepository(new \Modules\Icommerce\Entities\CouponOrderHistory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCouponOrderHistoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\PaymentMethodRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentPaymentMethodRepository(new \Modules\Icommerce\Entities\PaymentMethod());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CachePaymentMethodDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\TransactionRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTransactionRepository(new \Modules\Icommerce\Entities\Transaction());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheTransactionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\CartRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCartRepository(new \Modules\Icommerce\Entities\Cart());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCartDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\CartProductRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCartProductRepository(new \Modules\Icommerce\Entities\CartProduct());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCartProductDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\RelatedProductRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentRelatedProductRepository(new \Modules\Icommerce\Entities\RelatedProduct());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheRelatedProductDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\CartProductOptionRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCartProductOptionRepository(new \Modules\Icommerce\Entities\CartProductOption());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCartProductOptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ShippingMethodRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentShippingMethodRepository(new \Modules\Icommerce\Entities\ShippingMethod());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheShippingMethodDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ShippingMethodGeozoneRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentShippingMethodGeozoneRepository(new \Modules\Icommerce\Entities\ShippingMethodGeozone());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheShippingMethodGeozoneDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\PaymentMethodGeozoneRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentPaymentMethodGeozoneRepository(new \Modules\Icommerce\Entities\PaymentMethodGeozone());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CachePaymentMethodGeozoneDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductableRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductableRepository(new \Modules\Icommerce\Entities\Productable());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductableDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\CouponableRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCouponableRepository(new \Modules\Icommerce\Entities\Couponable());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCouponableDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\WeightClassRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentWeightClassRepository(new \Modules\Icommerce\Entities\WeightClass());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheWeightClassDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\LengthClassRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentLengthClassRepository(new \Modules\Icommerce\Entities\LengthClass());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheLengthClassDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\VolumeClassRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentVolumeClassRepository(new \Modules\Icommerce\Entities\VolumeClass());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheVolumeClassDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\QuantityClassRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentQuantityClassRepository(new \Modules\Icommerce\Entities\QuantityClass());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheQuantityClassDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductOptionValueRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductOptionValueRepository(new \Modules\Icommerce\Entities\ProductOptionValue());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductOptionValueDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\WarehouseRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentWarehouseRepository(new \Modules\Icommerce\Entities\Warehouse());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheWarehouseDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductWarehouseRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductWarehouseRepository(new \Modules\Icommerce\Entities\ProductWarehouse());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductWarehouseDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductOptionValueWarehouseRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductOptionValueWarehouseRepository(new \Modules\Icommerce\Entities\ProductOptionValueWarehouse());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductOptionValueWarehouseDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\SubscriptionRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentSubscriptionRepository(new \Modules\Icommerce\Entities\Subscription());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheSubscriptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\SubscriptionStatusHistoryRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentSubscriptionStatusHistoryRepository(new \Modules\Icommerce\Entities\SubscriptionStatusHistory());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheSubscriptionStatusHistoryDecorator($repository);
            }
        );


        // add bindings
    }


  /**
   * Register all commands for this module
   */
  private function registerCommands()
  {
    $this->registerUpdateCartCommand();
  }

  /**
   * Register the refresh thumbnails command
   */
  private function registerUpdateCartCommand()
  {
    $this->app['command.icommerce.update-cart'] = $this->app->make(UpdateCarts::class);
    $this->commands(['ccommand.icommerce.update-cart']);
  }

  /**
   * Register components
   */

  private function registerComponents()
  {
    Blade::componentNamespace("Modules\Icommerce\View\Components", 'icommerce');
  }

  /**
   * Register components Livewire
   */
  private function registerComponentsLivewire()
  {
    Livewire::component('icommerce::cart', \Modules\Icommerce\Http\Livewire\Cart::class);
    Livewire::component('icommerce::cart-button', \Modules\Icommerce\Http\Livewire\Cart::class);
    Livewire::component('icommerce::checkout', \Modules\Icommerce\Http\Livewire\Checkout::class);
    Livewire::component('icommerce::addToCartButton', \Modules\Icommerce\Http\Livewire\AddToCartButton::class);
    Livewire::component('icommerce::options', \Modules\Icommerce\Http\Livewire\Options\Options::class);
    Livewire::component('icommerce::options.item', \Modules\Icommerce\Http\Livewire\Options\ItemOption::class);
    Livewire::component('icommerce::warehouse-locator', \Modules\Icommerce\Http\Livewire\WarehouseLocator::class);
    Livewire::component('icommerce::warehouse-show-infor', \Modules\Icommerce\Http\Livewire\WarehouseShowInfor::class);
  }
}
