<?php

namespace Modules\Gallery\MenuExtenders;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
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

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.content'), function (Group $group) {
            $group->weight(10);

            $group->item(trans('gallery::gallery.title.gallery'), function (Item $item) {
                $item->weight(20);
                $item->icon('fa fa-picture-o');
                $item->route('backend::gallery.gallery.index');
                $item->authorize(
                    $this->auth->hasAccess('gallery.gallery.index')
                );
            });

        });

        return $menu;
    }
}
