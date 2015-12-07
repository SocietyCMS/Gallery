<?php

namespace Modules\Gallery\Http\Controllers\backend;

use Modules\Gallery\Repositories\AlbumRepository;
use Pingpong\Modules\Routing\Controller;

class GalleryController extends Controller
{
    /**
     * @var AlbumRepository
     */
    private $album;

    public function __construct(AlbumRepository $album)
    {
        $this->album = $album;
    }

    public function index()
    {
        $albums = $this->album->all();

        return view('gallery::backend.index', compact('albums'));
    }

    public function show($slug)
    {
        $album = $this->album->findBySlug($slug);

        return view('gallery::backend.show', compact('album'));
    }
}
