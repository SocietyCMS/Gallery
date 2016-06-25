export const add_gallery = ({dispatch}, payload) => dispatch('ADD_GALLERY', payload)

export const add_galleries = function ({dispatch}, payload) {
    payload.forEach((gallery) => {
        dispatch('ADD_GALLERY', gallery)
    })
}

export const remove_gallery = ({dispatch}, payload) => dispatch('REMOVE_GALLERY', payload)

export const set_selected_gallery = ({dispatch}, gallery) => dispatch('SELECTED_GALLERY', gallery)


export const add_photo = ({dispatch}, payload) => dispatch('ADD_PHOTO', payload)

export const add_photos = function ({dispatch}, photos) {
    dispatch('CLEAR_PHOTOS');
    photos.forEach((photo) => {
        dispatch('ADD_PHOTO',  photo)
    })
}

export const remove_photo = ({dispatch}, payload) => dispatch('REMOVE_PHOTO', payload)