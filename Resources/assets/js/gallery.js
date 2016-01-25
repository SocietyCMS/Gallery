import Album from './components/Album.vue';

new Vue({
    el: '#societyAdmin',
    data: {
        gallery: null,
        meta: null
    },
    components: {Album},
    ready: function () {
        this.$http.get(resourceGalleryAlbumIndex, function (data, status, request) {
            this.$set('gallery', data.data);
            this.$set('meta', data.meta);
        }).error(function (data, status, request) {
        })
    },

    methods: {
    }
});