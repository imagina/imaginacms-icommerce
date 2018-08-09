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
            $event->load('comments', array_dot(trans('icommerce::comments')));
            $event->load('categories', array_dot(trans('icommerce::categories')));
            $event->load('products', array_dot(trans('icommerce::products')));
            $event->load('manufacturers', array_dot(trans('icommerce::manufacturers')));
            $event->load('options', array_dot(trans('icommerce::options')));
            $event->load('coupons', array_dot(trans('icommerce::coupons')));
            $event->load('shipping_couriers', array_dot(trans('icommerce::shipping_couriers')));
            $event->load('currencies', array_dot(trans('icommerce::currencies')));
            $event->load('orders', array_dot(trans('icommerce::orders')));
            $event->load('product_discounts', array_dot(trans('icommerce::product_discounts')));
            $event->load('option_values', array_dot(trans('icommerce::option_values')));
            $event->load('product_options', array_dot(trans('icommerce::product_options')));
            $event->load('product_option_values', array_dot(trans('icommerce::product_option_values')));
            $event->load('order_products', array_dot(trans('icommerce::order_products')));
            $event->load('order_option', array_dot(trans('icommerce::order_option')));
            $event->load('order_history', array_dot(trans('icommerce::order_history')));
            $event->load('order_shipments', array_dot(trans('icommerce::order_shipments')));
            $event->load('coupon_categories', array_dot(trans('icommerce::coupon_categories')));
            $event->load('coupon_products', array_dot(trans('icommerce::coupon_products')));
            $event->load('coupon_histories', array_dot(trans('icommerce::coupon_histories')));
            $event->load('wishlists', array_dot(trans('icommerce::wishlists')));
            $event->load('payments', array_dot(trans('icommerce::payments')));
            $event->load('shippings', array_dot(trans('icommerce::shippings')));
            $event->load('slug_translations', array_dot(trans('icommerce::slug_translations')));
            $event->load('taxrates', array_dot(trans('icommerce::taxrates')));
            $event->load('taxclasses', array_dot(trans('icommerce::taxclasses')));
            $event->load('taxclassrates', array_dot(trans('icommerce::taxclassrates')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('icommerce', 'permissions');
        $this->publishConfig('icommerce', 'settings');
        $this->publishConfig('icommerce', 'config');

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

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheTagDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\CommentRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCommentRepository(new \Modules\Icommerce\Entities\Comment());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCommentDecorator($repository);
            }
        );
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
            'Modules\Icommerce\Repositories\Shipping_CourierRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentShipping_CourierRepository(new \Modules\Icommerce\Entities\Shipping_Courier());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheShipping_CourierDecorator($repository);
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
            'Modules\Icommerce\Repositories\Product_DiscountRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProduct_DiscountRepository(new \Modules\Icommerce\Entities\Product_Discount());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProduct_DiscountDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Option_ValueRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOption_ValueRepository(new \Modules\Icommerce\Entities\Option_Value());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOption_ValueDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Product_OptionRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProduct_OptionRepository(new \Modules\Icommerce\Entities\Product_Option());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProduct_OptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Product_Option_ValueRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentProduct_Option_ValueRepository(new \Modules\Icommerce\Entities\Product_Option_Value());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheProduct_Option_ValueDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Order_ProductRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrder_ProductRepository(new \Modules\Icommerce\Entities\Order_Product());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrder_ProductDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Order_OptionRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrder_OptionRepository(new \Modules\Icommerce\Entities\Order_Option());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrder_OptionDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Order_HistoryRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrder_HistoryRepository(new \Modules\Icommerce\Entities\Order_History());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrder_HistoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Order_ShipmentRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentOrder_ShipmentRepository(new \Modules\Icommerce\Entities\Order_Shipment());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheOrder_ShipmentDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Coupon_CategoryRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCoupon_CategoryRepository(new \Modules\Icommerce\Entities\Coupon_Category());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCoupon_CategoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Coupon_ProductRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCoupon_ProductRepository(new \Modules\Icommerce\Entities\Coupon_Product());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCoupon_ProductDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Coupon_HistoryRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentCoupon_HistoryRepository(new \Modules\Icommerce\Entities\Coupon_History());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheCoupon_HistoryDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\WishlistRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentWishlistRepository(new \Modules\Icommerce\Entities\Wishlist());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheWishlistDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\PaymentRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentPaymentRepository(new \Modules\Icommerce\Entities\Payment());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CachePaymentDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\ShippingRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentShippingRepository(new \Modules\Icommerce\Entities\Shipping());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheShippingDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\Slug_TranslationsRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentSlug_TranslationsRepository(new \Modules\Icommerce\Entities\Slug_Translations());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheSlug_TranslationsDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Icommerce\Repositories\TaxRatesRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTaxRatesRepository(new \Modules\Icommerce\Entities\TaxRates());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheTaxRatesDecorator($repository);
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
            'Modules\Icommerce\Repositories\TaxClassRatesRepository',
            function () {
                $repository = new \Modules\Icommerce\Repositories\Eloquent\EloquentTaxClassRatesRepository(new \Modules\Icommerce\Entities\TaxClassRates());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Icommerce\Repositories\Cache\CacheTaxClassRatesDecorator($repository);
            }
        );

// add bindings



























    }
}
