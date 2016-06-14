import Album from './components/Album.vue';

require('../less/Gallery.less');

new Vue({
    el: '#societyAdmin',
    data: {
        gallery: null,
        meta: null,
        newAlbum: {
            title: null,
            description: null
        }
    },
    components: {Album},
    created: function () {
        this.$http.get(societycms.api.gallery.album.index, function (data, status, request) {
            this.$set('gallery', data.data);
            this.$set('meta', data.meta);
        }).error(function (data, status, request) {
        })
    },

    methods: {
        newAlbumModal: function() {
            $('#newAlbumModal')
                .modal('setting', 'transition', 'fade up')
                .modal('show');
        },
        createNewAlbum: function() {
            var resource = this.$resource(societycms.api.gallery.album.store);

            resource.save(this.newAlbum, function (data, status, request) {
            }).error(function (data, status, request) {
            });
        },
    }
});