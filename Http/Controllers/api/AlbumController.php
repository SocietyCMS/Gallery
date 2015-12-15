<?php

namespace Modules\Gallery\Http\Controllers\api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ApiBaseController;
use Modules\Gallery\Repositories\AlbumRepository;
use Modules\Gallery\Repositories\PhotoRepository;
use Modules\Gallery\Transformers\AlbumTransformer;

class AlbumController extends ApiBaseController
{
    /**
     * @var AlbumRepository
     */
    private $album;

    /**
     * @var PhotoRepository
     */
    private $photo;

    public function __construct(AlbumRepository $album, PhotoRepository $photo)
    {
        parent::__construct();
        $this->album = $album;
        $this->photo = $photo;
    }

    public function index(Request $request)
    {
        $albums = $this->album->paginate();

        return $this->response->paginator($albums, new AlbumTransformer());
    }

    public function store(Request $request)
    {
        $album = $this->album->create([
            'title'     => $request->title,
            'slug'      => $this->album->getSlugForTitle($request->title),
            'published' => $request->published ?: 0,
        ]);

        return $this->successCreated();
    }

    public function show(Request $request, $slug)
    {
        $album = $this->album->findBySlug($slug);

        return $this->response->item($album, new AlbumTransformer());
    }

    public function update(Request $request, $slug)
    {
        $album = $this->album->findBySlug($slug);
        $album->update(['title' => $request->title]);

        return $this->response->item($album, new AlbumTransformer());
    }

    public function destroy(Request $request, $slug)
    {
        $album = $this->album->findBySlug($slug);

        foreach ($album->photos as $photo) {
            $photo->delete();
        }
        $album->delete();

        $this->successDeleted();
    }
}
