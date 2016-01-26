@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ trans('gallery::gallery.title.all albums') }}
@endsection

@section('content')

    <a class="ui primary button" href="">
        <i class="add user icon"></i>
        New User
    </a>

    <div class="ui six doubling link cards gallery">
        <album :album="album" v-for="album in gallery"></album>
    </div>


    <div class="ui basic modal">
        <i class="close icon"></i>
        <div class="header">
            Give your new Album an name
        </div>
        <div class="content">
            <div class="description">
                <div class="ui massive inverted transparent fluid input">
                    <input type="text" placeholder="Album Title...">
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="two fluid ui inverted buttons">
                <div class="ui green inverted button">
                    <i class="checkmark icon"></i>
                    Create
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="{{\Pingpong\Modules\Facades\Module::asset('gallery:css/Gallery.css')}}" rel="stylesheet" type="text/css">
@endsection
@section('javascript')
    <script>

        var resourceGalleryAlbumIndex = '{{apiRoute('v1', 'api.gallery.album.index')}}';
        var resourceGalleryAlbumUpdate = '{{apiRoute('v1', 'api.gallery.album.update', ['album' => ':id'])}}';

    </script>
    <script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/gallery.js')}}"></script>

@endsection
