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
            <div class="item" v-on:click="deleteAlbumModal">
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

        <h1 class="ui center aligned icon header" v-if="album.photos && album.photos.total == 0" id="noPhotosPlaceholder">
            <i class="grey cloud upload icon"></i>
            This album is empty
            <div class="sub header">You can drag&drop photos here to upload.</div>
        </h1>
    </div>


    <div class="ui dimmer" v-bind:class="{'active':deleting}">
        <div class="ui large text loader">Deleting Album....</div>
    </div>


    <div class="ui small modal"  id="deleteAlbumModal">
        <div class="header"> Delete album?</div>
        <div class="content">
            <p>Deleting an album is permanent. All Photos in this album are going to be deleted.</p>
        </div>
        <div class="actions">
                <div class="ui red inverted button" v-on:click="deleteAlbum">
                    <i class="trash icon"></i>
                    Delete
                </div>
                <div class="ui positive blue button">
                    Keep Album
                </div>
        </div>
    </div>

@endsection

@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('gallery:css/Gallery.css')}}" rel="stylesheet"
          type="text/css">
@endsection

@section('javascript')
    <script>
        var backendGalleryAlbumIndex = '{{route('backend::gallery.gallery.index')}}';
    </script>
    <script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/album.js')}}"></script>

@endsection
