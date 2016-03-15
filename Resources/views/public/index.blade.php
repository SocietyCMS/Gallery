@extends('layouts.master')

@section('title')
    Gallery
@stop

@section('content')

    <div class="row">
        @foreach ($albums as $album)
            @if($album->photos->count() > 0)
                <div class="col-xs-6 col-md-3">
                    <a href="{{route('gallery.show', $album->slug)}}"><img src="{{ $album->cover->first()->getFirstMediaUrl('images', 'wide320')}}" class="img-thumbnail" alt="{{$album->title}}"></a>
                    <h3><a href="{{route('gallery.show', $album->slug)}}">{{$album->title}}</a></h3>
                </div>
            @endif
        @endforeach

    </div>
@stop
