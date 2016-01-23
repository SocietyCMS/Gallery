@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ trans('gallery::gallery.title.all albums') }}
@endsection

@section('content')
    <div>

        <alert type="error">Something Went Wrong!</alert>
        <h1>Hello App!</h1>
        <p>
            <!-- use v-link directive for navigation. -->
            <a v-link="{ path: '/foo' }">Go to Foo</a>
            <a v-link="{ path: '/bar' }">Go to Bar</a>
        </p>
        <!-- route outlet -->
        <router-view></router-view>
    </div>
@endsection

@section('javascript')
    <script>

        var resourceGalleryAlbumIndex = '{{apiRoute('v1', 'api.gallery.album.index')}}';
        var resourceGalleryAlbumUpdate = '{{apiRoute('v1', 'api.gallery.album.update', ['album' => ':id'])}}';

    </script>
    <script src="{{\Pingpong\Modules\Facades\Module::asset('gallery:js/app.js')}}"></script>

@endsection





@section('content1')

    <div class="ui blue segment">
        <a href="#" id="createNewAlbumButton"
           class="fluid ui blue button">{{trans('gallery::gallery.button.create album')}}</a>
    </div>

    <div class="ui five column grid">
        <div class="column" v-for="album in gallery" style="display: none" v-show="gallery">

            <div class="ui special fluid card">
                <div class="blurring dimmable image">
                    <div class="ui dimmer">
                        <div class="content">
                            <div class="center">
                                <a v-bind:href="album.links.backend" class="ui inverted button">{{trans('core::elements.action.edit resource', ['name'=>trans('gallery::gallery.title.gallery')])}}</a>
                            </div>
                        </div>
                    </div>
                    <img src="" v-bind:src="album.cover.data.image.thumbnail.cover">
                </div>

                <div class="content">
                    <a v-bind:href="album.links.backend" class="header" v-if="updateAlbumSlug != album.slug">@{{ album.title }}</a>

                    <div class="ui action input" v-if="updateAlbumSlug == album.slug">
                        <input type="text" v-model="album.title" lazy v-on:change="updateAlbum(album.title)">
                        <button class="ui primary icon button" v-on:click="updateAlbumTitleToggle(album.slug)">
                            <i class="check icon"></i>
                        </button>
                    </div>

                    <div class="meta">
                        <span class="date"></span>
                    </div>
                    <div class="description">

                    </div>
                </div>

                <div class="extra content">
                    <a v-on:click="deleteAlbumModal(album.slug)" class="right floated">
                        <i class="red trash outline icon"></i>
                        @lang('core::elements.button.delete')
                    </a>
                    <a v-on:click="updateAlbumTitleToggle(album.slug)">
                        <i class="pencil icon"></i>
                        @lang('core::elements.button.edit')
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('htmlComponents1')
    <form class="ui modal" id="createNewAlbumModal">
        <i class="close icon"></i>

        <div class="header">
            {{trans('gallery::gallery.modal.create album')}}
        </div>
        <div class="content">
            <div class="ui form">
                <div class="field">
                    <label>{{trans('gallery::gallery.form.album name')}}</label>
                    <input type="text" name="title">
                </div>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                {{ trans('core::elements.button.cancel') }}
            </div>
            <button class="ui positive right labeled icon button">
                {{ trans('core::elements.button.create') }}
                <i class="checkmark icon"></i>
            </button>
        </div>
    </form>

    <div class="ui modal" id="deleteAlbumModal">
        <i class="close icon"></i>

        <div class="header">
            {{trans('gallery::gallery.modal.delete album')}}
        </div>
        <div class="content">

        </div>
        <div class="actions">
            <div class="ui black deny button">
                {{ trans('core::elements.button.cancel') }}
            </div>
            <button class="ui positive right labeled icon button" v-on:click="deleteAlbum">
                {{ trans('core::elements.button.create') }}
                <i class="checkmark icon"></i>
            </button>
        </div>
    </div>
@endsection


@section('javascript1')
    <script src="{{\Pingpong\Modules\Facades\Module::asset('documents:js/app.js')}}"></script>
    <script>

        var resourceGalleryAlbumIndex = '{{apiRoute('v1', 'api.gallery.album.index')}}';
        var resourceGalleryAlbumUpdate = '{{apiRoute('v1', 'api.gallery.album.update', ['album' => ':id'])}}';




        $('#createNewAlbumModal')
                .modal('attach events', '#createNewAlbumButton', 'show');

        $('#createNewAlbumModal .positive.button')
                .api({
                    url: '{{apiRoute('v1', 'api.gallery.album.store')}}',
                    method: 'POST',
                    serializeForm: true,
                    beforeXHR: function (xhr) {
                        xhr.setRequestHeader ('Authorization', 'Bearer {{$jwtoken}}');
                        return xhr;
                    },
                    onSuccess: function (response) {
                        location.reload();
                    }
                });



    </script>
@endsection
