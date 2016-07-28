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

        <div class="ui grid">
            <div class="twelve wide column">
                <div v-dropzone id="photosGrid"
                     :begin-callback="beginningUpload"
                     :progress-callback="progressUpload"
                     :success-callback="successfulUpload"
                     v-bind:upload-url="uploadUrl"
                     style="min-height: 30em; border: 1px solid red">
                    <waterfall
                            line="h"
                            :line-gap="200"
                            min-line-gap="160"
                            max-line-gap="240"
                            :watch="selected_gallery_photos"
                    >
                        <waterfall-slot v-for="photo in selected_gallery_photos"
                                        :width="photo.properties.width"
                                        :height="photo.properties.height"
                                        :order="$index">
                            <photo :photo="photo"></photo>
                        </waterfall-slot>
                    </waterfall>

                </div>

                <div v-for="file in uploadingFiles" track-by="$index">{{file.name}} :: {{file.progress}} </div>
            </div>
            <div class="four wide column" id="photos-detail-rail">
                <div class="ui segment sticky photo-detail">
                   <photo-detail></photo-detail>
                </div>
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
    import {set_selected_gallery, remove_gallery, add_photo, add_photos, set_selected_photo} from '../vuex/actions';
    import {Waterfall, WaterfallSlot} from 'vue-waterfall'

    import Photo from './Photo.vue';
    import PhotoDetail from './PhotoDetail.vue';


    Vue.directive('dropzone', {
        twoWay: true,

        params: ['uploadUrl', 'beginCallback',  'successCallback', 'progressCallback'],

        bind() {

        },
        update() {

            var self = this

            new Dropzone(this.el, {
                url: this.params.uploadUrl,
                headers: {
                    "Authorization": Vue.http.headers.common['Authorization']
                },
                paramName: "image",

                addedfile(file) {
                    self.params.beginCallback(file)
                },
                success(file, response) {
                    self.params.successCallback(file, response.data)
                },
                uploadprogress(file, progress) {
                    self.params.progressCallback(file, progress)
                }
            });

        },
        unbind() {
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
                    this.selectFirstPhoto()
                }.bind(this))
            },
            activate: function (transition) {
                transition.next();
            }
        },

        components: {
            Photo,
            PhotoDetail,
            Waterfall,
            WaterfallSlot
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
                set_selected_photo,
                remove_gallery,
            }
        },

        data() {
            return {
                uploadingFiles: []
            }
        },

        computed: {
            uploadUrl: function () {
                return Vue.url(societycms.api.gallery.album.photo.store, {album: this.selected_gallery.slug});
            }
        },

        watch: {
            '$loadingRouteData': function (val, oldVal) {
                this.$nextTick(function () {
                    $('.photo-detail').sticky({
                        offset: 10,
                        context: '#photos-detail-rail'
                    });
                });
            },
        },

        methods: {

            beginningUpload(file) {
                console.log('beginn:', file)

                file.progress = 0

                this.uploadingFiles.push(file)
            },

            progressUpload(file, progress) {
                console.log('progress:', file, progress)

                file.progress = progress

                this.uploadingFiles.$set(file, file)
            },

            successfulUpload(file, response) {
                console.log('success:', file, response)
                this.uploadingFiles.$remove(file)
            },

            updateAlbum() {
                var resource = this.$resource(societycms.api.gallery.album.update);
                resource.update({album: this.selected_gallery.slug}, {title: this.selected_gallery.title}, function (data, status, request) {
                }).error(function (data, status, request) {
                });
            },

            selectFirstPhoto() {
                if(this.selected_gallery_photos.length >= 1) {
                    this.set_selected_photo(this.selected_gallery_photos[0])
                }
            },

            deleteAlbumModal() {
                $('#deleteAlbumModal')
                        .modal('setting', 'transition', 'fade up')
                        .modal('show');
            },

            deleteAlbum() {

                $('#deleteAlbumModal').modal('hide');

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