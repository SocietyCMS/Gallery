<template>
    <form class="ui form" v-if="selected_gallery_selected_photo">
        <div class="field">
            <img id="photo-id" class="ui rounded image"
                 v-bind:src="thumbnailImage">
        </div>

        <div class="field">
            <label>Title</label>
            <input type="text" v-model="selected_gallery_selected_photo.title">
        </div>

        <div class="field">
            <label>Caption</label>
            <input type="text" v-model="selected_gallery_selected_photo.caption">
        </div>

        <div class="ui primary button" @click="save">
            Save
        </div>

        <button class="ui negative button" @click="delete">Delete</button>

    </form>

</template>

<script type="text/babel">

    import {remove_photo} from '../vuex/actions';

    export default {
        data() {
            return {
                isFocused: false,
                confirmDelete: false,
            };
        },
        vuex: {
            getters: {
                selected_gallery_selected_photo: (state) => state.selected_gallery_selected_photo,
                selected_gallery: (state) => state.selected_gallery,
            },
            actions: {
                remove_photo,
            }
        },

        computed: {
            thumbnailImage() {
                try {
                    return this.selected_gallery_selected_photo.thumbnail.medium;
                } catch (error) {
                }
            },
        },

        watch: {
            'selected_gallery_selected_photo': function (val, oldVal) {
                this.$nextTick(function () {
                    $('.photo-detail').sticky('refresh');
                });
            },
        },

        methods: {
            save() {

                var resource = this.$resource(societycms.api.gallery.album.photo.update);
                resource.update({
                    album: this.selected_gallery.slug,
                    photo: this.selected_gallery_selected_photo.id
                }, {
                    title: this.selected_gallery_selected_photo.title,
                    caption: this.selected_gallery_selected_photo.caption
                }, function (data, status, request) {
                }).error(function (data, status, request) {
                });
            },

            delete() {

                var resource = this.$resource(societycms.api.gallery.album.photo.destroy);
                resource.delete({
                    album: this.selected_gallery.slug,
                    photo: this.selected_gallery_selected_photo.id
                }, {}, function (data, status, request) {
                    this.remove_photo(this.selected_gallery_selected_photo)
                }).error(function (data, status, request) {
                });
            }
        }
    };
</script>
