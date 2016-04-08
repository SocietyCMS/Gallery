@extends('layouts.master')

@section('title')
    Gallery
@stop

@section('content')

    <div class="row">
        @foreach ($albums as $album)
            @if($album->photos->count() > 0)

                <div class="col-sm-4">
                    <a href="{{route('gallery.show', $album->slug)}}">
                        <img src="{{ $album->cover->first()->getFirstMediaUrl('images', 'wide320')}}" class="img-fluid img-rounded" alt="{{$album->title}}">
                    </a>
                    <h1>
                        <a href="{{route('gallery.show', $album->slug)}}">{{$album->title}}</a>
                    </h1>
                </div>
            @endif
        @endforeach

    </div>
@stop
