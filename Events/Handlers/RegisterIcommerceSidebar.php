<?php

namespace Modules\Icommerce\Events\Handlers;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\User\Contracts\Authentication;

class RegisterIcommerceSidebar implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    public function handle(BuildingSidebar $sidebar)
    {
        $sidebar->add($this->extendWith($sidebar->getMenu()));
    }

    /**
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item(trans('icommerce::icommerces.title.icommerces'), function (Item $item) {
                $item->icon('fa fa-copy');
                $item->weight(10);
                $item->authorize(
                     /* append */
                );
                $item->item(trans('icommerce::tags.title.tags'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.tag.create');
                    $item->route('admin.icommerce.tag.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.tags.index')
                    );
                });
                $item->item(trans('icommerce::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.category.create');
                    $item->route('admin.icommerce.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.categories.index')
                    );
                });
                $item->item(trans('icommerce::manufacturers.title.manufacturers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.manufacturer.create');
                    $item->route('admin.icommerce.manufacturer.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.manufacturers.index')
                    );
                });
                $item->item(trans('icommerce::products.title.products'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.product.create');
                    $item->route('admin.icommerce.product.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.products.index')
                    );
                });
                $item->item(trans('icommerce::producttags.title.producttags'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.producttag.create');
                    $item->route('admin.icommerce.producttag.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.producttags.index')
                    );
                });
                $item->item(trans('icommerce::productcategories.title.productcategories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.productcategory.create');
                    $item->route('admin.icommerce.productcategory.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.productcategories.index')
                    );
                });
                $item->item(trans('icommerce::options.title.options'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.option.create');
                    $item->route('admin.icommerce.option.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.options.index')
                    );
                });
                $item->item(trans('icommerce::coupons.title.coupons'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.coupon.create');
                    $item->route('admin.icommerce.coupon.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.coupons.index')
                    );
                });
                $item->item(trans('icommerce::shippingcouriers.title.shippingcouriers'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.shippingcourier.create');
                    $item->route('admin.icommerce.shippingcourier.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.shippingcouriers.index')
                    );
                });
                $item->item(trans('icommerce::currencies.title.currencies'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.currency.create');
                    $item->route('admin.icommerce.currency.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.currencies.index')
                    );
                });
                $item->item(trans('icommerce::orders.title.orders'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.order.create');
                    $item->route('admin.icommerce.order.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.orders.index')
                    );
                });
                $item->item(trans('icommerce::productdiscounts.title.productdiscounts'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.productdiscount.create');
                    $item->route('admin.icommerce.productdiscount.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.productdiscounts.index')
                    );
                });
                $item->item(trans('icommerce::optionvalues.title.optionvalues'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.optionvalue.create');
                    $item->route('admin.icommerce.optionvalue.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.optionvalues.index')
                    );
                });
                $item->item(trans('icommerce::productoptions.title.productoptions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.productoption.create');
                    $item->route('admin.icommerce.productoption.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.productoptions.index')
                    );
                });
                $item->item(trans('icommerce::productoptionvalues.title.productoptionvalues'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.productoptionvalue.create');
                    $item->route('admin.icommerce.productoptionvalue.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.productoptionvalues.index')
                    );
                });
                $item->item(trans('icommerce::orderproducts.title.orderproducts'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.orderproduct.create');
                    $item->route('admin.icommerce.orderproduct.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.orderproducts.index')
                    );
                });
                $item->item(trans('icommerce::orderoptions.title.orderoptions'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.orderoption.create');
                    $item->route('admin.icommerce.orderoption.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.orderoptions.index')
                    );
                });
                $item->item(trans('icommerce::orderhistories.title.orderhistories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.orderhistory.create');
                    $item->route('admin.icommerce.orderhistory.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.orderhistories.index')
                    );
                });
                $item->item(trans('icommerce::ordershipments.title.ordershipments'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.ordershipment.create');
                    $item->route('admin.icommerce.ordershipment.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.ordershipments.index')
                    );
                });
                $item->item(trans('icommerce::couponcategories.title.couponcategories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.couponcategory.create');
                    $item->route('admin.icommerce.couponcategory.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.couponcategories.index')
                    );
                });
                $item->item(trans('icommerce::couponproducts.title.couponproducts'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.couponproduct.create');
                    $item->route('admin.icommerce.couponproduct.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.couponproducts.index')
                    );
                });
                $item->item(trans('icommerce::couponhistories.title.couponhistories'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.couponhistory.create');
                    $item->route('admin.icommerce.couponhistory.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.couponhistories.index')
                    );
                });
                $item->item(trans('icommerce::wishlists.title.wishlists'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.wishlist.create');
                    $item->route('admin.icommerce.wishlist.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.wishlists.index')
                    );
                });
                $item->item(trans('icommerce::payments.title.payments'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.payment.create');
                    $item->route('admin.icommerce.payment.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.payments.index')
                    );
                });
                $item->item(trans('icommerce::shippings.title.shippings'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.shipping.create');
                    $item->route('admin.icommerce.shipping.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.shippings.index')
                    );
                });
                $item->item(trans('icommerce::taxrates.title.taxrates'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.taxrate.create');
                    $item->route('admin.icommerce.taxrate.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.taxrates.index')
                    );
                });
                $item->item(trans('icommerce::taxclasses.title.taxclasses'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.taxclass.create');
                    $item->route('admin.icommerce.taxclass.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.taxclasses.index')
                    );
                });
                $item->item(trans('icommerce::taxclassrates.title.taxclassrates'), function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(0);
                    $item->append('admin.icommerce.taxclassrate.create');
                    $item->route('admin.icommerce.taxclassrate.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.taxclassrates.index')
                    );
                });
// append




























            });
        });

        return $menu;
    }
}
