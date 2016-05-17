<?php

namespace Modules\Gallery\Entities;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use Modules\Core\Traits\Media\useMediaConversions;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Photo extends Model implements HasMediaConversions
{
    use HasMediaTrait;
    use useMediaConversions;

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
    protected $table = 'gallery__photos';

    /**
     * The fillable properties of the model.
     *
     * @var array
     */
    protected $fillable = ['title', 'caption', 'height', 'width', 'filesize', 'captured_at', 'album_id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['captured_at'];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['media'];

    /**
     * Photos relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function album()
    {
        return $this->belongsTo('Modules\Gallery\Entities\Album', 'album_id');
    }
}
