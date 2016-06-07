@if($activity->subject->photos->count() > 0)
    <div class="event">
        <div class="label">
            <i class="photo icon"></i>
        </div>
        <div class="content">
            <div class="summary">
                {!!  trans(
                    'gallery::activities.created_object.summary',
                    [
                        'title' => $activity->subject->title,
                        'url' => route('gallery.show', $activity->subject->slug),
                    ]
                    ) !!}
                <div class="date">
                    {{$activity->created_at->diffForHumans()}}
                </div>
            </div>
            <div class="extra images">
                @foreach($activity->subject->photos->take(5) as $photo)
                    <a href="{{route('gallery.show', $activity->subject->slug)}}">
                        <img src="{{$photo->getFirstMediaUrl('images', 'thumbnail-square')}}">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
