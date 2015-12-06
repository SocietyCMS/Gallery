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
                <a href="{{route('gallery.show', $activity->subject->slug)}}">
                @foreach($activity->subject->photos->take(5) as $photo)
                    <img src="{{$photo->getFirstMediaUrl('images', 'original250')}}">
                @endforeach
                </a>
            </div>
        </div>
    </div>
@endif
