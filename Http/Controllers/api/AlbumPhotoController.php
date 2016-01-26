<?php

namespace Modules\Gallery\Http\Controllers\api;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Modules\Core\Http\Controllers\ApiBaseController;
use Modules\Core\Http\Requests\MediaImageRequest;
use Modules\Gallery\Repositories\AlbumRepository;
use Modules\Gallery\Repositories\PhotoRepository;
use Modules\Gallery\Transformers\PhotoTransformer;

/**
 * Class AlbumPhotoController
 * @package Modules\Gallery\Http\Controllers\api
 */
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

    /**
     * AlbumPhotoController constructor.
     * @param AlbumRepository $album
     * @param PhotoRepository $photo
     */
    public function __construct(AlbumRepository $album, PhotoRepository $photo)
    {
        parent::__construct();
        $this->album = $album;
        $this->photo = $photo;
    }

    /**
     * @param Request $request
     * @param         $album
     * @return mixed
     */
    public function index(Request $request, $album)
    {
        $photos = $this->album->findBySlug($album)->photos;

        return $this->response->collection($photos, new PhotoTransformer());
    }

    /**
     * @param MediaImageRequest $request
     * @param                   $album
     * @return mixed
     */
    public function store(MediaImageRequest $request, $album)
    {
        $album = $this->album->findBySlug($album);
        $photo = $this->photo->create([
            'album_id'      => $album->id,
            'captured_at'   => \Carbon\Carbon::now(),
        ]);

        $this->updateComputedProperties($photo, $request->files->get('image'));
        $photo->addMedia($request->files->get('image'))->toCollection('images');


        return $this->response->item($photo, new PhotoTransformer());
    }

    /**
     * @param Request $request
     * @param         $album
     * @param         $photoID
     * @return mixed
     */
    public function show(Request $request, $album, $photoID)
    {
        $photo = $this->photo->find($photoID);

        return $this->response->item($photo, new PhotoTransformer());
    }

    /**
     * @param Request $request
     * @param         $album
     * @param         $photoID
     */
    public function update(Request $request, $album, $photoID)
    {
        $photo = $this->photo->find($photoID);

        $photo->update([
                'title'   => $request->title,
                'caption' => $request->caption,
                ]);
    }

    /**
     * @param Request $request
     * @param         $album
     * @param         $photoID
     */
    public function destroy(Request $request, $album, $photoID)
    {
        $this->photo->find($photoID)->delete();
    }

    private function updateComputedProperties($photo, $imageFile)
    {
        $image = Image::make($imageFile);

        $photo->height = $image->height();
        $photo->width = $image->width();
        $photo->filesize = $image->filesize();
        $photo->captured_at = \Carbon\Carbon::parse($image->exif('DateTimeOriginal'));

        $photo->save();

    }
}
