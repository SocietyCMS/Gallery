<?php

namespace Modules\Gallery\Transformers;

use League\Fractal;
use Modules\Gallery\Entities\Album;

class AlbumTransformer extends Fractal\TransformerAbstract
{
    /**
     * List of resources possible to include.
     *
     * @var array
     */
    protected $availableIncludes = [
        'photos',
    ];

    /**
     * List of resources to automatically include.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'cover',
    ];

    public function transform(Album $album)
    {
        return [
            'title'      => $album->title,
            'slug'       => $album->slug,
            'published'  => (bool) $album->published,
            'photoCount' => $album->photos->count(),
            'links'      => [
                'api' => [
                    'album'  => apiRoute('v1', 'api.gallery.album.show', $album->slug),
                    'photos' => apiRoute('v1', 'api.gallery.album.photo.index', $album->slug),
                ],
                'backend' => route('backend::gallery.gallery.show', $album->slug),
            ],
        ];
    }

    /**
     * Include Photos.
     *
     * @param Album $album
     *
     * @return \League\Fractal\Resource\collection
     */
    public function includePhotos(Album $album)
    {
        $photos = $album->photos;

        return $this->collection($photos, new PhotoTransformer());
    }

    /**
     * Include AlbumCover.
     *
     * @param Album $album
     *
     * @return \League\Fractal\Resource\collection
     */
    public function includeCover(Album $album)
    {
        if (is_null($coverPhotos = $album->photos->first())) {
            return;
        }

        return $this->item($coverPhotos, new PhotoTransformer());
    }
}
