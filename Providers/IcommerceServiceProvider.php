<?php

namespace Modules\Icommerce\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Icommerce\Events\Handlers\RegisterIcommerceSidebar;

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
      $event->load('tags', array_dot(trans('icommerce::tags')));
      $event->load('categories', array_dot(trans('icommerce::categories')));
      $event->load('manufacturers', array_dot(trans('icommerce::manufacturers')));
      $event->load('products', array_dot(trans('icommerce::products')));
      $event->load('producttags', array_dot(trans('icommerce::producttags')));
      $event->load('productcategories', array_dot(trans('icommerce::productcategories')));
      $event->load('options', array_dot(trans('icommerce::options')));
      $event->load('coupons', array_dot(trans('icommerce::coupons')));
      $event->load('currencies', array_dot(trans('icommerce::currencies')));
      $event->load('orders', array_dot(trans('icommerce::orders')));
      $event->load('productdiscounts', array_dot(trans('icommerce::productdiscounts')));
      $event->load('optionvalues', array_dot(trans('icommerce::optionvalues')));
      $event->load('productoptions', array_dot(trans('icommerce::productoptions')));
      $event->load('productoptionvalues', array_dot(trans('icommerce::productoptionvalues')));
      $event->load('orderproducts', array_dot(trans('icommerce::orderproducts')));
      $event->load('orderoptions', array_dot(trans('icommerce::orderoptions')));
      $event->load('orderhistories', array_dot(trans('icommerce::orderhistories')));
      $event->load('ordershipments', array_dot(trans('icommerce::ordershipments')));
      $event->load('couponcategories', array_dot(trans('icommerce::couponcategories')));
      $event->load('couponproducts', array_dot(trans('icommerce::couponproducts')));
      $event->load('couponhistories', array_dot(trans('icommerce::couponhistories')));
      $event->load('wishlists', array_dot(trans('icommerce::wishlists')));
      $event->load('payments', array_dot(trans('icommerce::payments')));
      $event->load('shippings', array_dot(trans('icommerce::shippings')));
      $event->load('taxrates', array_dot(trans('icommerce::taxrates')));
      $event->load('taxclasses', array_dot(trans('icommerce::taxclasses')));
      $event->load('taxclassrates', array_dot(trans('icommerce::taxclassrates')));
      $event->load('carts', array_dot(trans('icommerce::carts')));
      $event->load('cartproducts', array_dot(trans('icommerce::cartproducts')));
      $event->load('itemtypes', array_dot(trans('icommerce::itemtypes')));
            $event->load('relatedproducts', array_dot(trans('icommerce::relatedproducts')));
            $event->load('lists', array_dot(trans('icommerce::lists')));
            $event->load('productlists', array_dot(trans('icommerce::productlists')));
            $event->load('paymentmethods', array_dot(trans('icommerce::paymentmethods')));
            // append translations





      
      
    });
  }
  
  public function boot()
  {
    $this->publishConfig('icommerce', 'permissions');
    
    $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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
      'Modules\Icommerce\Repositories\TagRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTagRepository(new \Modules\Icommerce\Entities\Tag());
        
        if (!config('app.cache')) {
          return $repository;
        }
        
        return new \Modules\Icommerce\Repositories\Cache\CacheTagDecorator($repository);
      }
    );
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
      'Modules\Icommerce\Repositories\TaxClassRateRepository',
      function () {
        $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTaxClassRateRepository(new \Modules\Icommerce\Entities\TaxClassRate());
        
        if (!config('app.cache')) {
          return $repository;
        }
        
        return new \Modules\Icommerce\Repositories\Cache\CacheTaxClassRateDecorator($repository);
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

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheItemTypeDecorator($repository);
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
            'Modules\Icommerce\Repositories\PriceListRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentPriceListRepository(new \Modules\Icommerce\Entities\PriceList());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CachePriceListDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ProductListRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProductListRepository(new \Modules\Icommerce\Entities\ProductList());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProductListDecorator($repository);
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
// add bindings





  
  
  }
}
