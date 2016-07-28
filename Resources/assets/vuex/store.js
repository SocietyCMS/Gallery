import Vuex from 'vuex'

//Vue.use(Vuex)

// root state object.
// each Vuex instance is just a single state tree.
const state = {
    galleries: [],
    selected_gallery: null,
    selected_gallery_photos: [],
    selected_gallery_selected_photo: null
}

// mutations are operations that actually mutates the state.
// each mutation handler gets the entire state tree as the
// first argument, followed by additional payload arguments.
// mutations must be synchronous and can be recorded by middlewares
// for debugging purposes.
const mutations = {
    ADD_GALLERY (state, gallery) {
        state.galleries.push(gallery);
    },

    REMOVE_GALLERY (state, galleryToRemove) {
        var tokenToRemove;
        state.galleries.forEach(function(gallery, index) {
            if(galleryToRemove.slug === gallery.slug) {
                tokenToRemove = index;
            }
        });
        state.galleries.splice(tokenToRemove, 1);
    },

    SELECTED_GALLERY (state, gallery) {
        state.selected_gallery = gallery;
    },

    CLEAR_PHOTOS (state) {
        state.selected_gallery_photos = [];
    },

    ADD_PHOTO (state, photo) {
        state.selected_gallery_photos.push(photo);
    },

    SELECT_PHOTO (state, photo) {
        state.selected_gallery_selected_photo = photo;
    },

    REMOVE_PHOTO (state, photo) {
        state.selected_gallery_photos.$remove(photo);
    },
}

// A Vuex instance is created by combining the state, the actions,
// and the mutations. Because the actions and mutations are just
// functions that do not depend on the instance itself, they can
// be easily tested or even hot-reloaded (see counter-hot example).
//
// You can also provide middlewares, which is just an array of
// objects containing some hooks to be called at initialization
// and after each mutation.
export default new Vuex.Store({
    state,
    mutations
})