@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    @{{ album.title }}
@endsection

@section('content')

    <div class="ui icon top left pointing right floated dropdown album ellipsis button">
        <i class="ellipsis vertical icon"></i>
        <div class="menu">
            <div class="item" id="uploadImageButton">
                <i class="cloud upload icon"></i>
                Upload Photos
            </div>
            <div class="divider"></div>
            <div class="item">
                <i class="trash outline icon"></i>
                Delete Album
            </div>
        </div>
    </div>

    <div class="ui massive transparent fluid icon input">
        <input type="text" placeholder="Album Title" @keyup="updateAlbum | debounce 200" v-model="album.title">
        <i class="write icon"></i>
    </div>

    <div class="ui divider"></div>

    <div class="ui photos" id="photosGrid">
        <photo :photo="photo" v-for="photo in photos"></photo>
    </div>

@endsection

@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('gallery:css/Gallery.css')}}" rel="stylesheet"
          type="text/css">
@endsection

@section('javascript')
    <script>
        var resourceGalleryAlbumUpdate = '{{apiRoute('v1', 'api.gallery.album.update', ['album' => $album->slug])}}';
        var resourceGalleryAlbumShow = '{{apiRoute('v1', 'api.gallery.album.show', ['album' => $album->slug])}}';

        var resourceGalleryAlbumPhotoIndex = '{{apiRoute('v1', 'api.gallery.album.photo.index', ['album' => $album->slug])}}';
        var resourceGalleryAlbumPhotoStore = '{{apiRoute('v1', 'api.gallery.album.photo.store', ['album' => $album->slug])}}';


        var jwtoken = '{{$jwtoken}}';
    </script>
    <script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/album.js')}}"></script>

@endsection
