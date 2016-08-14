<template>

    <div class="ui basic segment">
        <a class="ui primary button" v-on:click="newAlbumModal">
            <i class="photo icon"></i>
            {{ 'core::elements.action.create resource' | trans  }}
        </a>
    </div>


    <div class="ui five doubling link cards gallery">
        <album :album="album" v-for="album in galleries"></album>
    </div>

    <div class="ui modal" id="newAlbumModal">
        <div class="header">{{'gallery::gallery.modal.create album' | trans}}</div>
        <div class="content">
            <form class="ui form">
                <div class="ui field">
                    <label>{{'gallery::gallery.form.title'| trans }}</label>
                    <input type="text"  v-model="newAlbum.title">
                </div>

                <button class="ui green inverted fluid button" v-on:click="createNewAlbum"
                        v-bind:class="{'disabled':!newAlbum.title}">
                    <i class="checkmark icon"></i>
                    {{'core::elements.button.create'| trans}}
                </button>

            </form>
        </div>
    </div>

</template>

<script type="text/babel">
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
                newAlbum: {
                    title: null,
                    description: null
                }
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
            newAlbumModal: function() {
                $('#newAlbumModal')
                        .modal('setting', 'transition', 'fade up')
                        .modal('show');
            },
            createNewAlbum: function() {
                var resource = this.$resource(societycms.api.gallery.album.store);

                resource.save(this.newAlbum, function (data, status, request) {
                    $('#newAlbumModal').modal('hide');
                    this.$route.router.go({name:'show', params: { slug: data.data.slug }})
                }).error(function (data, status, request) {
                });
            },
        },
    };
</script>