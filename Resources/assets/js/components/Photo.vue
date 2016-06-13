<template>
    <div class="photo" data-w="{{photo.properties.width}}" data-h="{{photo.properties.height}}" @click="showDetails">
        <img id="photo-id-{{photo.id}}" class="ui rounded image"
             v-bind:data-src="thumbnailImage">
        <div class="ui active dimmer" v-if="photo.preview">
            <div class="ui indeterminate loader"></div>
        </div>
    </div>
</template>

<script>
    import flexImages from '../modules/fleximages';

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
                $('#photo-id-' + this.photo.id)
                        .visibility({
                            type: 'image',
                            transition: 'fade in',
                            duration: 1000,
                        });
                new flexImages({selector: '#photosGrid', container: '.photo', rowHeight: 225});
            }.bind(this))
        },
        methods: {
            showDetails: function () {
                this.photo.showdetails = true;


                $( "<div class='detail'></div>" ).insertAfter(
                        $('#photo-id-' + this.photo.id).parent().nextAll('.last-in-row')[0]
                )
            }
        }
    };
</script>
