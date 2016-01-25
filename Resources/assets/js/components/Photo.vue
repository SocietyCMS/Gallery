<style>
    .photo {
        height: 200px;
        margin: .5vw;
    }
    .photo img {
        width: auto;
        height: 100%;
    }
</style>

<template>
    <div class="photo">
        <img class="ui bordered image" src="" v-bind:src="photo.image.thumbnail.large">
    </div>
</template>

<script>
    export default {
        props: ['photo']
    };
</script>
