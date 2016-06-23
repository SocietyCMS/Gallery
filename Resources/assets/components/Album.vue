<template>
    <a class="card ui piled segment" @click="selectGallery(album)" v-link="{ name: 'show', params: { slug: album.slug }}">
        <div class="image">
            <div class="ui green right corner label" v-if="album.published">
                <i class="bookmark icon"></i>
            </div>
            <div class="ui yellow right corner label" v-if="!album.published">
                <i class="write icon"></i>
            </div>
            <img v-bind:src="album.cover.data.thumbnail.square" v-if="album.cover">
            <img src="/modules/gallery/images/no-preview.png" v-else>
        </div>
        <div class="content">
            <div class="header">{{ album.title }}</div>
        </div>
        <div class="extra content">
            <i class="photo icon"></i>
            {{ album.photos_count }}
        </div>
    </a>
</template>

<script>

    import { set_selected_gallery } from '../vuex/actions';

    export default {
        props: ['album'],

        vuex: {
            getters: {
                selected_gallery: function(state) {state.selected_gallery}
            },
            actions: {
                set_selected_gallery,
            }
        },
        methods: {
            selectGallery: function(album) {
                this.set_selected_gallery(album);
            }
        }
    };
</script>
