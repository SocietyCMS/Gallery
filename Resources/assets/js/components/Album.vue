<template>
    <a class="card" href="{{album.links.backend}}">
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
            {{ album.photos.total }}
        </div>
    </a>
</template>

<script>
    export default {
        props: ['album']
    };
</script>
