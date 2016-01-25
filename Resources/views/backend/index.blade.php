@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ trans('gallery::gallery.title.all albums') }}
@endsection

@section('content')

    <div class="ui six doubling link cards">
        <album :album="album" v-for="album in gallery"></album>
    </div>
@endsection

@section('javascript')
    <script>

        var resourceGalleryAlbumIndex = '{{apiRoute('v1', 'api.gallery.album.index')}}';
        var resourceGalleryAlbumUpdate = '{{apiRoute('v1', 'api.gallery.album.update', ['album' => ':id'])}}';

    </script>
    <script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/gallery.js')}}"></script>

@endsection