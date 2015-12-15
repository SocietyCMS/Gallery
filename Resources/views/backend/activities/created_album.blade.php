@if($activity->subject->photos->count() > 0)
    <div class="event">
        <div class="label">
            <i class="photo icon"></i>
        </div>
        <div class="content">
            <div class="summary">
                A new Gallery has been created: <a href="{{route('gallery.show', $activity->subject->slug)}}">{{$activity->subject->title}}</a>
                <div class="date">
                    {{$activity->created_at->diffForHumans()}}
                </div>
            </div>
            <div class="extra images">
                @foreach($activity->subject->photos->take(5) as $photo)
                    <a href="{{route('gallery.show', $activity->subject->slug)}}">
                        <img src="{{$photo->getFirstMediaUrl('images', 'wide160')}}">
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif
