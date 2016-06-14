export const add_gallery = ({dispatch}, payload) => dispatch('ADD_GALLERY', payload)

export const add_galleries = function ({dispatch}, payload) {
    payload.forEach((gallery) => {
        dispatch('ADD_GALLERY', gallery)
    })
}

export const select_gallery = ({dispatch}, gallery) => dispatch('SELECT_GALLERY', gallery)

export const add_photos = function ({dispatch}, photos) {
    dispatch('CLEAR_PHOTOS');
    photos.forEach((photo) => {
        dispatch('ADD_PHOTO',  photo)
    })
}