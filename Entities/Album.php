<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\User\Traits\Activity\RecordsActivity;

class Album extends Model
{
    use RecordsActivity;
    use PresentableTrait;

    /**
     * Presenter Class.
     *
     * @var string
     */
    protected $presenter = '';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'gallery__albums';

    /**
     * The fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = ['title', 'slug', 'published'];

    /**
     * Views for the Dashboard timeline.
     *
     * @var string
     */
    protected static $templatePath = 'gallery::backend.activities';

    /**
     * @var array
     */
    protected static $recordEvents = ['created'];

    /**
     * Photos relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function photos()
    {
        return $this->hasMany('Modules\Gallery\Entities\Photo');
    }

    /**
     * Photos relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cover()
    {
        return $this->photos();
    }
}
