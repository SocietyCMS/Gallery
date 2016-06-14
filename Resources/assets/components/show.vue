<template>
    <div class="ui active inverted dimmer" v-if="$loadingRouteData">
        <div class="ui large text loader">Loading</div>
    </div>

    <div v-if="!$loadingRouteData">
        <div class="ui photos" id="photosGrid">
            <photo :photo="photo" v-for="photo in selected_gallery_photos"></photo>
        </div>
    </div>
</template>

<script>
    import { select_gallery, add_photos } from '../vuex/actions';

    import Photo from './Photo.vue';

    export default {

        route: {
            data: function (transition) {
                this.$http.get(societycms.api.gallery.album.photo.index, {album:this.$route.params.slug}, function (data, status, request) {
                    this.add_photos(data.data)
                    transition.next()
                }).error(function (data, status, request) {
                });
            },
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
                select_gallery,
                add_photos,
            }
        },

        ready: function() {

        },

        methods: {
            requestPhotos: function() {

            }
        },
    };
</script>