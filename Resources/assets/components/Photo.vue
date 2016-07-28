<template>
    <div class="ui photo" @click="selectPhoto" v-bind:class="{'selected': selected_gallery_selected_photo == photo }">
        <img id="photo-id-{{photo.id}}" class="ui rounded image visible content"
             v-bind:src="thumbnailImage">
    </div>
</template>

<script type="text/babel">

    import {set_selected_photo} from '../vuex/actions';

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
                selected_gallery_selected_photo: (state) => state.selected_gallery_selected_photo,
            },
            actions: {
                set_selected_photo,
            }
        },

        computed: {
            thumbnailImage() {
                if (this.photo.thumbnail && this.photo.thumbnail.medium) {
                    return this.photo.thumbnail.medium
                }
            },
        },
        methods: {
            selectPhoto() {
                this.set_selected_photo(this.photo);
            }
        }
    };
</script>
