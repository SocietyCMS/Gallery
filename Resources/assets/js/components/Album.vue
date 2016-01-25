<template>
    <a class="card" href="{{album.links.backend}}">
        <div class="image">
            <div class="ui blue right corner label" v-if="album.published">
                <i class="bookmark icon"></i>
            </div>
            <img v-bind:src="album.cover.data.image.thumbnail.cover" >
        </div>
        <div class="content">
            <div class="header">{{ album.title }}</div>
            <div class="description">
                <div class="ui horizontal bulleted list">
                    <div class="item">
                        About Us
                    </div>
                    <div class="item">
                        Sitemap
                    </div>
                    <div class="item">
                        Contact
                    </div>
                </div>
            </div>
        </div>
        <div class="extra content">
            <i class="photo icon"></i>
            {{ album.photoCount }} Photos
        </div>
    </a>
</template>

<script>
    export default {
        props: ['album']
    };
</script>