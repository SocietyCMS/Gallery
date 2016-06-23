<template>
    <div class="ui instant move down reveal photo" data-w="{{photo.properties.width}}" data-h="{{photo.properties.height}}">
        <img id="photo-id-{{photo.id}}" class="ui rounded image visible content"
             v-bind:style="{ height: thumbnailHeight, width: thumbnailWidth}"
             v-bind:data-src="thumbnailImage">
        <div class="ui active dimmer" v-if="photo.preview">
            <div class="ui indeterminate loader"></div>
        </div>
        <div class="hidden content">

            <div class="center aligned photo-detail">
                <div class="ui inverted transparent fluid input">
                    <input type="text" v-model="photo.title">
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    import flexImages from '../js/modules/fleximages';

    export default {
        props: ['photo'],
        computed: {
            thumbnailImage: function () {
                if (this.photo.thumbnail && this.photo.thumbnail.medium) {
                    return this.photo.thumbnail.medium
                }
            },
            thumbnailHeight: function () {
                return '225px';
            },
            thumbnailWidth: function () {
                if (this.photo.properties && this.photo.properties.height && this.photo.properties.width) {
                    return Math.ceil((225 / this.photo.properties.height) * this.photo.properties.width) + 'px'
                }
            }
        },
        ready() {
            Vue.nextTick(function () {
                new flexImages({selector: '#photosGrid', container: '.photo', rowHeight: 225});
            }.bind(this))
        }
    };
</script>
