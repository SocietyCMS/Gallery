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
                {{trans('core::elements.action.upload resource', ['name'=>trans('gallery::gallery.title.photo')])}}
            </div>
            <div class="divider"></div>
            <div class="item" v-on:click="deleteAlbumModal">
                <i class="trash outline icon"></i>
                {{trans('core::elements.action.delete resource', ['name'=>trans('gallery::gallery.title.album')])}}
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
            {{ trans('gallery::gallery.info.this album is empty') }}
            <div class="sub header">{{ trans('gallery::gallery.info.drag-drop upload') }}</div>
        </h1>
    </div>

    <div class="ui dimmer" v-bind:class="{'active':deleting}">
        <div class="ui large text loader">{{ trans('gallery::gallery.info.deleting album') }}</div>
    </div>


    <div class="ui small modal"  id="deleteAlbumModal">
        <div class="header">{{ trans('gallery::gallery.modal.delete album') }}</div>
        <div class="content">
            <p>{{ trans('gallery::gallery.modal.delete album warning') }}</p>
        </div>
        <div class="actions">
                <div class="ui red inverted button" v-on:click="deleteAlbum">
                    <i class="trash icon"></i>
                    {{trans('core::elements.action.delete resource', ['name'=>trans('gallery::gallery.title.album')])}}
                </div>
                <div class="ui positive blue button">
                    {{trans('core::elements.action.keep resource', ['name'=>trans('gallery::gallery.title.album')])}}
                </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        var backendGalleryAlbumIndex = '{{route('backend::gallery.gallery.index')}}';
    </script>
    <script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/album.js')}}"></script>
@endsection
