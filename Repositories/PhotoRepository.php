<?php namespace Modules\Gallery\Repositories;

use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;


class PhotoRepository extends EloquentBaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return "Modules\\Gallery\\Entities\\Photo";
    }
}
