import Alert from './components/Alert.vue';

new Vue({
    el: '#societyAdmin',
    components: {Alert},
    ready(){
        console.log('ready');
    }
});


new Vue({
    el: '#societyAdmin',
    data: {
        gallery: null,
        meta: null
    },
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