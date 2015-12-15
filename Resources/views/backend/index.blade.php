@extends('layouts.master')

@section('title')
    {{ trans('gallery::gallery.title.gallery') }}
@endsection
@section('subTitle')
    {{ trans('gallery::gallery.title.all albums') }}
@endsection

@section('content')

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

@section('htmlComponents')
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


@section('javascript')
    <script>

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


        new Vue({
            el: '#societyAdmin',
            data: {
                gallery: null,
                meta: null,
                updateAlbumSlug: null,
                deleteAlbumSlug: null
            },
            ready: function () {
                this.$http.get('{{apiRoute('v1', 'api.gallery.album.index')}}', function (data, status, request) {
                    this.$set('gallery', data.data);
                    this.$set('meta', data.meta);

                    setTimeout(function () {
                        $('.special.card .image').dimmer({
                            on: 'hover'
                        });
                    }, 0);

                }).error(function (data, status, request) {
                })
            },
            methods: {
                deleteAlbumModal: function (slug) {
                    this.deleteAlbumSlug = slug;
                    $('#deleteAlbumModal')
                            .modal('show')
                    ;
                },
                updateAlbumTitleToggle: function (slug) {
                    if(this.updateAlbumSlug == null) {
                        return this.updateAlbumSlug = slug;
                    }
                    return this.updateAlbumSlug = null;
                },
                updateAlbum: function (text) {
                    var resource = this.$resource('{{apiRoute('v1', 'api.gallery.album.update', ['album' => ':id'])}}');

                    resource.update({id: this.updateAlbumSlug}, {title:text}, function (data, status, request) {
                    }).error(function (data, status, request) {
                    });
                },
                deleteAlbum: function () {
                    var resource = this.$resource('{{apiRoute('v1', 'api.gallery.album.destroy', ['album' => ':slug'])}}');

                    resource.delete({slug: this.deleteAlbumSlug},function (data, status, request) {
                        window.location.replace("{{route('backend::gallery.gallery.index')}}");
                    }).error(function (data, status, request) {
                    });
                }
            }
        });


    </script>
@endsection
