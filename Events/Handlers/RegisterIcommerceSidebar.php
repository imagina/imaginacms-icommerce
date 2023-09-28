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

    public function extendWith(Menu $menu): Menu
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->item('Tienda', function (Item $item) {
                $item->item('Administrar Tienda', function (Item $item) {
                    $item->icon('fa fa-copy');
                    $item->weight(10);
                    $item->route('admin.icommerce.store.index');
                    $item->authorize(
                        $this->auth->hasAccess('icommerce.products.index')
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
            });
        });

        return $menu;
    }
}
