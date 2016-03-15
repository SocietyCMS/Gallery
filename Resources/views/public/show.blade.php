@extends('layouts.master')

@section('title')
    {{ $album->title }}
@stop

@section('content')

    <div class="card-deck">
        @foreach($album->photos as $photo)
            <div class="card gallery-card">
                <a href="{{ $photo->getFirstMediaUrl('images')}}" class="fancybox" rel="{{$album->title}}" data-title="{{$photo->title}}" >
                    <img class="card-img" src="{{ $photo->getFirstMediaUrl('images', 'wide320')}}" alt="{{$photo->title}}">
                </a>
            </div>
        @endforeach
    </div>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css">
@stop
