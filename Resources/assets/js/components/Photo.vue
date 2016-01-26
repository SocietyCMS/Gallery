<template>
    <div class="photo">
        <img id="photo-id-{{photo.id}}" class="ui rounded image" v-bind:style="{ height: thumbnailHeight, width: thumbnailWidth }"
             v-bind:data-src="photo.thumbnail.large">
    </div>
</template>

<script>
    export default {
        props: ['photo'],
        computed: {
            thumbnailHeight: function () {
                return '225px';
            },
            thumbnailWidth: function () {
                return Math.ceil((225 / this.photo.properties.height) * this.photo.properties.width) + 'px'
            }
        },
        ready() {
            Vue.nextTick(function () {
                $('#photo-id-'+ this.photo.id)
                        .visibility({
                            type       : 'image',
                            transition : 'fade in',
                            duration   : 1000,
                        });
            }.bind(this))
        }
    };
</script>
