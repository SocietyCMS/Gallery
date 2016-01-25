import Photo from './components/Photo.vue';

new Vue({
    el: '#societyAdmin',
    data: {
        album:null,
        meta:null,
    },
    components: {Photo},
    ready: function () {
        this.$http.get(resourceGalleryAlbumPhotoIndex, function (data, status, request) {

            this.$set('album', data.data);
            this.$set('meta', data.meta);

        }).error(function (data, status, request) {
        });
    },

    methods: {
    }
});