@extends('layouts.master')

@section('title')
    {{ $album->title }} | @parent
@stop

@section('content')

    <div class="row">
        <div class="text-center">
            <h1>{{ $album->title }}</h1>
        </div>

        <hr>

        <div class="row">
            @foreach($album->photos as $photo)
                <div class="col-xs-6 col-md-3 padding-top-bottom">
                    <a href="{{ $photo->getFirstMediaUrl('images')}}" data-lightbox="{{$album->title}}" data-title="{{$photo->title}}" >
                        <img src="{{ $photo->getFirstMediaUrl('images', 'wide320')}}"  data-holder-rendered="true" class="img-thumbnail" alt="{{$photo->title}}">
                    </a>
                </div>
            @endforeach

        </div>

    </div>
@stop
