<?php

namespace Modules\Gallery\Repositories;

use Modules\Core\Repositories\Eloquent\EloquentSlugRepository;

class AlbumRepository extends EloquentSlugRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return 'Modules\\Gallery\\Entities\\Album';
    }
}
