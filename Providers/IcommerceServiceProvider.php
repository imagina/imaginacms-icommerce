<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Icommerce\Console\UpdateCarts;
use Modules\Icommerce\Entities\Product;
use Modules\Icommerce\Events\Handlers\RegisterIcommerceSidebar;
use Modules\Tag\Repositories\TagManager;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Livewire\Livewire;

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
   *
   * @return void
   */
  public function register()
  {
    $this->registerBindings();
    $this->app['events']->listen(BuildingSidebar::class, RegisterIcommerceSidebar::class);

    $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
      $event->load('categories', Arr::dot(trans('icommerce::categories')));
      $event->load('manufacturers', Arr::dot(trans('icommerce::manufacturers')));
      $event->load('products', Arr::dot(trans('icommerce::products')));
      $event->load('producttags', Arr::dot(trans('icommerce::producttags')));
      $event->load('productcategories', Arr::dot(trans('icommerce::productcategories')));
      $event->load('options', Arr::dot(trans('icommerce::options')));
      $event->load('coupons', Arr::dot(trans('icommerce::coupons')));
      $event->load('currencies', Arr::dot(trans('icommerce::currencies')));
      $event->load('orders', Arr::dot(trans('icommerce::orders')));
      $event->load('productdiscounts', Arr::dot(trans('icommerce::productdiscounts')));
      $event->load('optionvalues', Arr::dot(trans('icommerce::optionvalues')));
      $event->load('productoptions', Arr::dot(trans('icommerce::productoptions')));
      $event->load('productoptionvalues', Arr::dot(trans('icommerce::productoptionvalues')));
      $event->load('orderproducts', Arr::dot(trans('icommerce::orderproducts')));
      $event->load('orderoptions', Arr::dot(trans('icommerce::orderoptions')));
      $event->load('orderhistories', Arr::dot(trans('icommerce::orderhistories')));
      $event->load('orderstatuses', Arr::dot(trans('icommerce::orderstatuses')));
      $event->load('ordershipments', Arr::dot(trans('icommerce::ordershipments')));
      $event->load('couponcategories', Arr::dot(trans('icommerce::couponcategories')));
      $event->load('couponproducts', Arr::dot(trans('icommerce::couponproducts')));
      $event->load('couponhistories', Arr::dot(trans('icommerce::couponhistories')));
      $event->load('wishlists', Arr::dot(trans('icommerce::wishlists')));
      $event->load('payments', Arr::dot(trans('icommerce::payments')));
      $event->load('shippings', Arr::dot(trans('icommerce::shippings')));
      $event->load('taxrates', Arr::dot(trans('icommerce::taxrates')));
      $event->load('taxclasses', Arr::dot(trans('icommerce::taxclasses')));
      $event->load('carts', Arr::dot(trans('icommerce::carts')));
      $event->load('cartproducts', Arr::dot(trans('icommerce::cartproducts')));
      $event->load('itemtypes', Arr::dot(trans('icommerce::itemtypes')));
      $event->load('relatedproducts', Arr::dot(trans('icommerce::relatedproducts')));
      $event->load('lists', Arr::dot(trans('icommerce::lists')));
      $event->load('productlists', Arr::dot(trans('icommerce::productlists')));
      $event->load('paymentmethods', Arr::dot(trans('icommerce::paymentmethods')));
      $event->load('shippingmethods', Arr::dot(trans('icommerce::shippingmethods')));
      $event->load('shippingmethodgeozones', Arr::dot(trans('icommerce::shippingmethodgeozones')));
      $event->load('paymentmethodgeozones', Arr::dot(trans('icommerce::paymentmethodgeozones')));
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
    //$this->app[TagManager::class]->registerNamespace(new Product());
    $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');

    $this->registerComponents();
    $this->registerComponentsLivewire();
  }

  /**
   * Get the services provided by the provider.
   *
   * @return array
   */
  public function provides()
  {
    return array();
  }

  private function registerBindings()
  {
    $this->app->bind(
      'Modules\Icommerce\Repositories\CategoryRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCategoryRepository(new \Modules\Icommerce\Entities\Category());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheCategoryDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ManufacturerRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentManufacturerRepository(new \Modules\Icommerce\Entities\Manufacturer());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheManufacturerDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ProductRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductRepository(new \Modules\Icommerce\Entities\Product());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheProductDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ProductTagRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductTagRepository(new \Modules\Icommerce\Entities\ProductTag());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheProductTagDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ProductCategoryRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductCategoryRepository(new \Modules\Icommerce\Entities\ProductCategory());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheProductCategoryDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\OptionRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOptionRepository(new \Modules\Icommerce\Entities\Option());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheOptionDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\CouponRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCouponRepository(new \Modules\Icommerce\Entities\Coupon());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheCouponDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\CurrencyRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCurrencyRepository(new \Modules\Icommerce\Entities\Currency());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheCurrencyDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\OrderRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderRepository(new \Modules\Icommerce\Entities\Order());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheOrderDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ProductDiscountRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductDiscountRepository(new \Modules\Icommerce\Entities\ProductDiscount());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheProductDiscountDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\OptionValueRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOptionValueRepository(new \Modules\Icommerce\Entities\OptionValue());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheOptionValueDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ProductOptionRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductOptionRepository(new \Modules\Icommerce\Entities\ProductOption());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheProductOptionDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ProductOptionValueRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductOptionValueRepository(new \Modules\Icommerce\Entities\ProductOptionValue());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheProductOptionValueDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\OrderProductRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderProductRepository(new \Modules\Icommerce\Entities\OrderProduct());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheOrderProductDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\OrderOptionRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderOptionRepository(new \Modules\Icommerce\Entities\OrderOption());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheOrderOptionDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\OrderHistoryRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderHistoryRepository(new \Modules\Icommerce\Entities\OrderStatusHistory());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheOrderHistoryDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\OrderStatusRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderStatusRepository(new \Modules\Icommerce\Entities\OrderStatus());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheOrderStatusDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\OrderShipmentRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrderShipmentRepository(new \Modules\Icommerce\Entities\OrderShipment());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheOrderShipmentDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\CouponCategoryRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCouponCategoryRepository(new \Modules\Icommerce\Entities\CouponCategory());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheCouponCategoryDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\CouponProductRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCouponProductRepository(new \Modules\Icommerce\Entities\CouponProduct());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheCouponProductDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\CouponHistoryRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCouponHistoryRepository(new \Modules\Icommerce\Entities\CouponOrderHistory());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheCouponHistoryDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\WishlistRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentWishlistRepository(new \Modules\Icommerce\Entities\Wishlist());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheWishlistDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\TransactionRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTransactionRepository(new \Modules\Icommerce\Entities\Transaction());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheTransactionDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ShippingRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentShippingRepository(new \Modules\Icommerce\Entities\Shipping());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheShippingDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\TaxRateRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTaxRateRepository(new \Modules\Icommerce\Entities\TaxRate());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheTaxRateDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\TaxClassRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTaxClassRepository(new \Modules\Icommerce\Entities\TaxClass());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheTaxClassDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\CartRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCartRepository(new \Modules\Icommerce\Entities\Cart());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheCartDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\CartProductRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCartProductRepository(new \Modules\Icommerce\Entities\CartProduct());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheCartProductDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ItemTypeRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentItemTypeRepository(new \Modules\Icommerce\Entities\ItemType());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheItemTypeDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\RelatedProductRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentRelatedProductRepository(new \Modules\Icommerce\Entities\RelatedProduct());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheRelatedProductDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\PriceListRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentPriceListRepository(new \Modules\Icommerce\Entities\PriceList());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CachePriceListDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ProductListRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductListRepository(new \Modules\Icommerce\Entities\ProductList());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheProductListDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\PaymentMethodRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentPaymentMethodRepository(new \Modules\Icommerce\Entities\PaymentMethod());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CachePaymentMethodDecorator($repository);
      }
    );

    $this->app->bind(
      'Modules\Icommerce\Repositories\ShippingMethodRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentShippingMethodRepository(new \Modules\Icommerce\Entities\ShippingMethod());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheShippingMethodDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\ShippingMethodGeozoneRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentShippingMethodGeozoneRepository(new \Modules\Icommerce\Entities\ShippingMethodGeozone());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheShippingMethodGeozoneDecorator($repository);
      }
    );
    $this->app->bind(
      'Modules\Icommerce\Repositories\PaymentMethodGeozoneRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentPaymentMethodGeozoneRepository(new \Modules\Icommerce\Entities\PaymentMethodGeozone());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CachePaymentMethodGeozoneDecorator($repository);
      }
    );

    $this->app->bind(
      'Modules\Icommerce\Repositories\StoreRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentStoreRepository(new \Modules\Icommerce\Entities\Store());

        if (!config('app.cache')) {
          return $repository;
        }

        return new \Modules\Icommerce\Repositories\Cache\CacheStoreDecorator($repository);
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

  private function registerComponents(){
    Blade::componentNamespace("Modules\Icommerce\View\Components", 'icommerce');
  }

  /**
   * Register components Livewire
   */
  private function registerComponentsLivewire()
  {

    Livewire::component('icommerce::product-list', \Modules\Icommerce\Http\Livewire\Index\ProductList::class);
    Livewire::component('icommerce::filter-categories', \Modules\Icommerce\Http\Livewire\Index\Filters\Categories::class);
    Livewire::component('icommerce::filter-range-prices', \Modules\Icommerce\Http\Livewire\Index\Filters\RangePrices::class);
    Livewire::component('icommerce::filter-manufacturers', \Modules\Icommerce\Http\Livewire\Index\Filters\Manufacturers::class);
    Livewire::component('icommerce::cart', \Modules\Icommerce\Http\Livewire\Cart::class);
    Livewire::component('icommerce::wishlist', \Modules\Icommerce\Http\Livewire\Wishlist::class);
    Livewire::component('icommerce::filter-product-options', \Modules\Icommerce\Http\Livewire\Index\Filters\ProductOptions::class);
    Livewire::component('icommerce::filter-product-types', \Modules\Icommerce\Http\Livewire\Index\Filters\ProductTypes::class);
  }


}
