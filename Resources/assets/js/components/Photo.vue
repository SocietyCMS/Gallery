<template>
    <div class="photo">
        <img class="ui bordered image" src=""
             v-bind:data-src="photo.image.thumbnail.large">
    </div>
</template>

<script>
    export default {
        props: ['photo'],
        ready() {
            $('.photo img')
                    .visibility({
                        type       : 'image',
                        transition : 'fade in',
                        duration   : 1000
                    });
        }
    };
</script>
