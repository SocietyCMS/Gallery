@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ trans('gallery::gallery.title.all albums') }}
@endsection

@section('content')

    <a class="ui primary button" v-on:click="newAlbumModal">
        <i class="add user icon"></i>
        New Album
    </a>

    <div class="ui six doubling link cards gallery">
        <album :album="album" v-for="album in gallery"></album>
    </div>

    <div class="ui modal"  id="newAlbumModal">
        <div class="header"> Give your new Album an name</div>
        <div class="content">
            <form class="ui form">
                <div class="ui field">
                    <label>Title</label>
                    <input type="text" placeholder="Album Title..." v-model="newAlbum.title">
                </div>
                <div class="field">
                    <label>Description</label>
                    <textarea rows="2" v-model="newAlbum.description"></textarea>
                </div>

                <div class="ui green inverted fluid button" v-on:click="createNewAlbum" v-bind:class="{'disabled':!newAlbum.title}">
                    <i class="checkmark icon"></i>
                    Create
                </div>

            </form>
        </div>
    </div>

@endsection

@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('gallery:css/Gallery.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('javascript')
    <script>

        var resourceGalleryAlbumIndex = '{{apiRoute('v1', 'api.gallery.album.index')}}';
        var resourceGalleryAlbumStore = '{{apiRoute('v1', 'api.gallery.album.store')}}';
        var resourceGalleryAlbumUpdate = '{{apiRoute('v1', 'api.gallery.album.update', ['album' => ':id'])}}';

    </script>
    <script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/gallery.js')}}"></script>

@endsection
