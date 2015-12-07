<?php

namespace Modules\Gallery\Transformers;

use League\Fractal;
use Modules\Gallery\Entities\Photo;

class PhotoTransformer extends Fractal\TransformerAbstract
{
    public function transform(Photo $photo)
    {
        return [
            'id'      => (int) $photo->id,
            'title'   => $photo->title,
            'caption' => $photo->caption,
            'image'   => [
                'original'  => $photo->getFirstMediaUrl('images'),
                'thumbnail' => [
                    'square' => $photo->getFirstMediaUrl('images', 'square100'),
                    'small'  => $photo->getFirstMediaUrl('images', 'original100'),
                    'medium' => $photo->getFirstMediaUrl('images', 'original250'),
                    'large'  => $photo->getFirstMediaUrl('images', 'original400'),
                    'cover'  => $photo->getFirstMediaUrl('images', 'cover900'),
                ],
            ],
            'properties' => [
                'filename'          => $photo->getFirstMedia('images') ? $photo->getFirstMedia('images')->file_name : null,
                'size'              => $photo->getFirstMedia('images') ? $photo->getFirstMedia('images')->size : null,
                'humanReadableSize' => $photo->getFirstMedia('images') ? $photo->getFirstMedia('images')->humanReadableSize : null,
                'uploaded_on'       => $photo->created_at->toDateTimeString(),
                'modified_on'       => $photo->updated_at->toDateTimeString(),
                'captured_on'       => $photo->captured_at->toDateTimeString(),
            ],

        ];
    }
}
