<template>
    <div class="ui instant move down reveal photo" v-bind:class="{ 'active': isFocused }"
         data-w="{{photo.properties.width}}"
         data-h="{{photo.properties.height}}">
        <img id="photo-id-{{photo.id}}" class="ui rounded image visible content"
             v-bind:style="{ height: thumbnailHeight, width: thumbnailWidth}"
             v-bind:data-src="thumbnailImage">
        <div class="ui active dimmer" v-if="photo.preview">
            <div class="ui indeterminate loader"></div>
        </div>
        <div class="hidden content photo-detail">
            <div class="content">
                <div class="ui huge fluid input">
                    <input type="text" placeholder="Title"
                           v-model="photo.title"
                           v-on:focus="isFocused = true"
                           v-on:blur="isFocused = false"
                           debounce="500">
                </div>

                <div class="buttons">
                    <div class="ui inverted red icon button " v-on:click="confirmDelete = true" v-show="!confirmDelete">
                        <i class="trash icon"></i></div>

                    <div class="ui buttons" v-show="confirmDelete">
                        <div class="ui button" v-on:click="confirmDelete = false">Cancel</div>
                        <div class="ui negative button" v-on:click="deletePhoto">Delete</div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</template>

<script type="text/babel">

    import flexImages from '../js/modules/fleximages';

    import {remove_photo} from '../vuex/actions';

    export default {
        props: ['photo'],
        data() {
            return {
                isFocused: false,
                confirmDelete: false,
            };
        },
        vuex: {
            getters: {
                selected_gallery: (state) => state.selected_gallery,
            },
            actions: {
                remove_photo,
            }
        },

        computed: {
            thumbnailImage() {
                if (this.photo.thumbnail && this.photo.thumbnail.medium) {
                    return this.photo.thumbnail.medium
                }
            },
            thumbnailHeight() {
                return '225px';
            },
            thumbnailWidth() {
                if (this.photo.properties && this.photo.properties.height && this.photo.properties.width) {
                    return Math.ceil((225 / this.photo.properties.height) * this.photo.properties.width) + 'px'
                }
            }
        },
        ready() {
            Vue.nextTick(function () {
                new flexImages({selector: '#photosGrid', container: '.photo', rowHeight: 225});
            }.bind(this))
        },
        methods: {
            deletePhoto() {
                var resource = this.$resource(societycms.api.gallery.album.photo.destroy);

                resource.delete({
                    album: this.selected_gallery.slug,
                    photo: this.photo.id
                }, this.photo, function (data, status, request) {
                    this.remove_photo(this.photo);
                }).error(function (data, status, request) {
                });
            }
        }
    };
</script>
