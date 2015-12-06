<?php namespace Modules\Gallery\MenuExtenders;

;
use Modules\Core\Contracts\Authentication;
use Modules\Menu\Repositories\Menu\MenuRepository;

class MenuExtender implements \Modules\Menu\Repositories\MenuExtender
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
     * @param MenuRepository $menuRepository
     *
     * @return MenuRepository
     */
    public function extendWith(MenuRepository $menuRepository)
    {
        $menuRepository->mainMenu()->route('gallery.index', trans('gallery::gallery.title.gallery'), [], 1, [
            'active' => function () {
                return \Route::is('gallery.index') || \Route::is('gallery.show');
            }
        ]);

        return $menuRepository;
    }
}
