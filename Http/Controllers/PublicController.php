<?php namespace Modules\Gallery\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\PublicBaseController;
use Modules\Gallery\Repositories\AlbumRepository;
use Modules\Gallery\Repositories\PhotoRepository;

class PublicController extends PublicBaseController
{
    /**
     * @var AlbumRepository
     */
    private $album;

    /**
     * @var PhotoRepository
     */
    private $photo;

    /**
     * @var Application
     */
    private $app;

    public function __construct(AlbumRepository $album, PhotoRepository $photo, Application $app)
    {
        parent::__construct();
        $this->album = $album;
        $this->photo = $photo;
        $this->app = $app;
    }

    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $albums = $this->album->paginate();
        return view('gallery::public.index', compact('albums'));
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function show($slug)
    {
        $album = $this->album->findBySlug($slug);

        $this->throw404IfNotFound($album);

        return view('gallery::public.show', compact('album'));
    }

    /**
     * Throw a 404 error page if the given page is not found
     * @param $page
     */
    private function throw404IfNotFound($album)
    {
        if (is_null($album)) {
            $this->app->abort('404');
        }
    }
}
