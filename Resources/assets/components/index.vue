<template>
    <a class="ui primary button" >
        <i class="add user icon"></i>
    </a>

    <div class="ui six doubling link cards gallery">
        <album :album="album" v-for="album in galleries"></album>
    </div>
</template>

<script>
    import Album from './Album.vue';

    import { add_gallery, add_galleries } from '../vuex/actions';

    export default {

        components: {
            Album
        },

        props: {
        },

        data() {
            return {
            };
        },

        vuex: {
            getters: {
                galleries: (state) => state.galleries
            },
            actions: {
                add_gallery,
                add_galleries
            }
        },

        created: function () {
            this.$http.get(societycms.api.gallery.album.index, function (data, status, request) {
                this.add_galleries(data.data);
            }).error(function (data, status, request) {
            })
        },

        methods: {
        },
    };
</script>