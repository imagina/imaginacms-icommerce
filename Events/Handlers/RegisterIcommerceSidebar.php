<?php

namespace Modules\Icommerce\Events\Handlers;

use Maatwebsite\Sidebar\Badge;
use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Events\BuildingSidebar;
use Modules\Icommerce\Repositories\ManufacturerRepository;
use Modules\Icommerce\Repositories\OrderRepository;
use Modules\Icommerce\Repositories\CommentRepository;
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
            $group->item(trans('icommerce::common.sidebar.products'), function (Item $item) {
                $item->icon('fa fa-object-group');
                $item->weight(10);
                $item->item(trans('icommerce::products.title.products'), function (Item $item) {
                    $item->icon('fa fa-object-group');
                    $item->weight(0);
                    $item->append('admin.icommerce.product.create');
                    $item->route('admin.icommerce.product.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.products.index')
                    );
                });
                $item->item(trans('icommerce::categories.title.categories'), function (Item $item) {
                    $item->icon('fa fa-list-ul');
                    $item->weight(0);
                    $item->append('crud.icommerce.category.create');
                    $item->route('crud.icommerce.category.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.categories.index')
                    );
                });
                $item->item(trans('icommerce::tags.title.tags'), function (Item $item) {
                    $item->icon('fa fa-tags');
                    $item->weight(0);
                    $item->append('crud.icommerce.tag.create');
                    $item->route('crud.icommerce.tag.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.tags.index')
                    );
                });
                $item->item(trans('icommerce::options.title.options'), function (Item $item) {
                    $item->icon('fa fa-cogs');
                    $item->weight(0);
                    $item->append('admin.icommerce.option.create');
                    $item->route('admin.icommerce.option.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.options.index')
                    );
                });
                $item->item(trans('icommerce::products.bulkload.import'), function (Item $item) {
                    $item->icon('fa fa-upload');
                    $item->weight(0);
                    $item->route('admin.icommerce.bulkload.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.bulkload.import')
                    );
                });

                $item->authorize(
                    $this->auth->hasAccess('icommerce.products.index') or $this->auth->hasAccess('icommerce.categories.index') or $this->auth->hasAccess('icommerce.tags.index') or $this->auth->hasAccess('icommerce.options.index')
                );

            });
            $group->item(trans('icommerce::manufacturers.title.manufacturers'), function (Item $item) {
                $item->icon('fa fa-building');
                $item->weight(11);
                $item->route('crud.icommerce.manufacturer.index');
                $item->badge(function (Badge $badge, ManufacturerRepository $manufacturerRepository) {
                    $badge->setClass('bg-green');
                    $badge->setValue($manufacturerRepository->countAll());
                });
                $item->authorize(
                    $this->auth->hasAccess('icommerce.manufacturers.index')
                );
            });
            $group->item(trans('icommerce::common.sidebar.shipping'), function (Item $item) {
                $item->icon('fa fa-truck');
                $item->weight(12);
                $item->item(trans('icommerce::shipping_couriers.title.shipping_couriers'), function (Item $item) {
                    $item->icon('fa fa-truck');
                    $item->weight(0);
                    $item->append('crud.icommerce.shipping_courier.create');
                    $item->route('crud.icommerce.shipping_courier.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.shipping_couriers.index')
                    );
                });
                $item->item(trans('icommerce::shippings.title.shippings'), function (Item $item) {
                    $item->icon('fa fa-paper-plane-o');
                    $item->weight(0);
                    $item->route('admin.icommerce.shipping.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.shippings.index')
                    );
                });
                $item->authorize(
                    $this->auth->hasAccess('icommerce.shippings.index') or $this->auth->hasAccess('icommerce.shipping_couriers.index')
                );
            });
            $group->item(trans('icommerce::common.sidebar.paymentsanddiscount'), function (Item $item) {
                $item->icon('fa fa-credit-card');
                $item->weight(13);
                $item->item(trans('icommerce::payments.title.payments'), function (Item $item) {
                    $item->icon('fa fa-credit-card');
                    $item->weight(0);
                    $item->route('admin.icommerce.payment.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.payments.index')
                    );
                });
                $item->item(trans('icommerce::currencies.title.currencies'), function (Item $item) {
                    $item->icon('fa fa-money');
                    $item->weight(0);
                    $item->append('crud.icommerce.currency.create');
                    $item->route('crud.icommerce.currency.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.currencies.index')
                    );
                });
                $item->item(trans('icommerce::coupons.title.coupons'), function (Item $item) {
                    $item->icon('fa fa-newspaper-o');
                    $item->weight(0);
                    $item->append('crud.icommerce.coupon.create');
                    $item->route('crud.icommerce.coupon.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.coupons.index')
                    );
                });
                $item->authorize(
                    $this->auth->hasAccess('icommerce.currencies.index') or $this->auth->hasAccess('icommerce.payments.index') or $this->auth->hasAccess('icommerce.coupons.index')
                );
            });

            $group->item(trans('icommerce::orders.title.orders'), function (Item $item) {
                $item->icon('fa fa-pencil-square-o');
                $item->weight(14);
                $item->badge(function (Badge $badge, OrderRepository $orderRepository) {
                    $badge->setClass('bg-green');
                    $badge->setValue($orderRepository->countStatus(10));
                });
                $item->route('admin.icommerce.order.index');
                $item->authorize(
                    $this->auth->hasAccess('icommerce.orders.index')
                );
            });

            if(config('asgard.icommerce.config.comments')){

                $group->item(trans('icommerce::comments.title.comments'), function (Item $item) {
                    $item->icon('fa fa-comments-o');
                    $item->weight(15);
                    $item->badge(function (Badge $badge, CommentRepository $commentRepository) {
                        $badge->setClass('bg-green');
                        $badge->setValue($commentRepository->countAll());
                    });
                    $item->route('crud.icommerce.comment.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.comments.index')
                    );
                });

            }
           

        });

        return $menu;
    }
}
