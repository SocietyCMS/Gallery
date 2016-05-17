<?php

namespace Modules\Gallery\Transformers;

use League\Fractal;
use Modules\Gallery\Entities\Photo;

class PhotoTransformer extends Fractal\TransformerAbstract
{
    public function transform(Photo $photo)
    {
        return [
            'id'         => (int)$photo->id,
            'title'      => $photo->title,
            'caption'    => $photo->caption,
            'image'      => $photo->getFirstMediaUrl('images'),
            'thumbnail'  => [
                'square' => $photo->getFirstMediaUrl('images', 'thumbnail-square'),
                'small'  => $photo->getFirstMediaUrl('images', 'thumbnail-small'),
                'medium' => $photo->getFirstMediaUrl('images', 'thumbnail-medium'),
                'large'  => $photo->getFirstMediaUrl('images', 'thumbnail-large'),
            ],
            'properties' => [
                'filename'    => $photo->getFirstMedia('images') ? $photo->getFirstMedia('images')->file_name : null,
                'filesize'    => $photo->filesize,
                'height'      => $photo->height,
                'width'       => $photo->width,
                'uploaded_on' => $photo->created_at->toDateTimeString(),
                'modified_on' => $photo->updated_at->toDateTimeString(),
                'captured_on' => $photo->captured_at->toDateTimeString(),
            ],

        ];
    }
}
