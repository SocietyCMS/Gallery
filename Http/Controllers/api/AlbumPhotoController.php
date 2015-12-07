<?php

namespace Modules\Gallery\Http\Controllers\api;

use Illuminate\Http\Request;
use Modules\Core\Http\Controllers\ApiBaseController;
use Modules\Gallery\Repositories\AlbumRepository;
use Modules\Gallery\Repositories\PhotoRepository;
use Modules\Gallery\Transformers\PhotoTransformer;

class AlbumPhotoController extends ApiBaseController
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

    public function index(Request $request, $album)
    {
        $photos = $this->album->findBySlug($album)->photos;

        return $this->response->collection($photos, new PhotoTransformer());
    }

    public function store(Request $request, $album)
    {
        $album = $this->album->findBySlug($album);
        $photo = $this->photo->create([
            'album_id'      => $album->id,
            'captured_at'   => \Carbon\Carbon::now(),
        ]);

        $photo->addMedia($request->files->get('qqfile'))->toCollection('images');

        return $this->response->item($photo, new PhotoTransformer());
    }

    public function show(Request $request, $album, $photoID)
    {
        $photo = $this->photo->find($photoID);

        return $this->response->item($photo, new PhotoTransformer());
    }

    public function update(Request $request, $album, $photoID)
    {
        $photo = $this->photo->find($photoID);

        $photo->update([
                'title'   => $request->title,
                'caption' => $request->caption,
                ]);
    }

    public function destroy(Request $request, $album, $photoID)
    {
        $this->photo->find($photoID)->delete();
    }
}
