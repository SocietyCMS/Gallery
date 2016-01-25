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
