@extends('layouts.master')

@section('title')
    {{ $album->title }}
@stop

@section('content')

    <div class="card-deck">
        @foreach($album->photos as $photo)
            <div class="card gallery-card">
                <a href="{{ $photo->getFirstMediaUrl('images')}}" class="lightbox" data-lightbox="{{$album->title}}" data-title="{{$photo->title}}" >
                    <img class="card-img" src="{{ $photo->getFirstMediaUrl('images', 'original250')}}" alt="{{$photo->title}}">
                </a>
            </div>
        @endforeach
    </div>
@stop
