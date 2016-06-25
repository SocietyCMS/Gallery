<template>
    <div class="ui active inverted dimmer" v-if="$loadingRouteData">
        <div class="ui large text loader">Loading</div>
    </div>

    <div v-if="!$loadingRouteData">

        <div class="ui right floated icon button" v-on:click="deleteAlbumModal">
            <i class="trash outline icon"></i>
        </div>
        <div class="ui right floated icon button" id="uploadImageButton">
            <i class="cloud upload icon"></i>
        </div>
        <div class="ui massive transparent fluid input">
            <input type="text" @keyup="updateAlbum | debounce 200" v-model="selected_gallery.title">
        </div>

        <div class="ui divider"></div>

        <div v-dropzone="add_photo" v-bind:upload-url="uploadUrl" style="min-height: 30em; border: 1px solid red">
            <div class="ui photos" id="photosGrid">
                <photo :photo="photo" v-for="photo in selected_gallery_photos"></photo>
            </div>
        </div>
    </div>

    <div class="ui small modal" id="deleteAlbumModal">
        <div class="header">{{ 'gallery::gallery.modal.delete album' | trans }}</div>
        <div class="content">
            <p>{{ 'gallery::gallery.modal.delete album warning' | trans }}</p>
        </div>
        <div class="actions">
            <div class="ui red inverted button" v-on:click="deleteAlbum">
                <i class="trash icon"></i>
                {{ 'core::elements.button.delete' | trans }}
            </div>
            <div class="ui positive blue button">
                {{ 'core::elements.button.cancel' | trans }}
            </div>
        </div>
    </div>

</template>

<script type="text/babel">
    import {set_selected_gallery, remove_gallery, add_photo, add_photos} from '../vuex/actions';

    import Photo from './Photo.vue';

    Vue.directive('dropzone', {
        twoWay: true,

        params: ['uploadUrl'],

        bind: function () {

        },
        update: function (callback) {

            new Dropzone(this.el, {
                url: this.params.uploadUrl,
                headers: {
                    "Authorization": Vue.http.headers.common['Authorization']
                },
                paramName: "image",

                addedfile: function (file) {
                },
                success: function (file, response) {
                    console.log(file, response);
                    callback(response.data)
                },
            });

        },
        unbind: function () {
        }
    })

    export default {

        route: {
            data: function (transition) {
                return Promise.all([
                    this.$http.get(societycms.api.gallery.album.show, {album: this.$route.params.slug}),
                    this.$http.get(societycms.api.gallery.album.photo.index, {album: this.$route.params.slug}),
                ]).then(function ([gallery, photos]) {
                    this.set_selected_gallery(gallery.data.data);
                    this.add_photos(photos.data.data);
                }.bind(this))
            },
            activate: function (transition) {
                transition.next();
            }
        },

        components: {
            Photo
        },

        vuex: {
            getters: {
                selected_gallery: (state) => state.selected_gallery,
                selected_gallery_photos: (state) => state.selected_gallery_photos,
            },
            actions: {
                set_selected_gallery,
                add_photo,
                add_photos,
                remove_gallery,
            }
        },

        computed: {
            uploadUrl: function () {
                return Vue.url(societycms.api.gallery.album.photo.store, {album: this.selected_gallery.slug});
            }
        },

        methods: {

            updateAlbum: function () {
                var resource = this.$resource(societycms.api.gallery.album.update);
                resource.update({album: this.selected_gallery.slug}, {title: this.selected_gallery.title}, function (data, status, request) {
                }).error(function (data, status, request) {
                });
            },

            deleteAlbumModal: function () {
                $('#deleteAlbumModal')
                        .modal('setting', 'transition', 'fade up')
                        .modal('show');
            },
            deleteAlbum: function () {

                $('#deleteAlbumModal')
                        .modal('hide');

                var resource = this.$resource(societycms.api.gallery.album.destroy);

                resource.delete({album: this.selected_gallery.slug}, this.album, function (data, status, request) {
                    this.remove_gallery(this.selected_gallery);
                    this.$router.go({name: 'index'});
                }).error(function (data, status, request) {
                });

            }
        },
    };
</script>