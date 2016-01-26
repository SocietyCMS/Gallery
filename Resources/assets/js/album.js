import Photo from './components/Photo.vue';

var VueInstance = new Vue({
    el: '#societyAdmin',
    data: {
        photos: null,
        album: {
            title: null
        },
        meta: null
    },
    components: {Photo},
    ready: function () {
        this.$http.get(resourceGalleryAlbumPhotoIndex, function (data, status, request) {
            this.$set('photos', data.data);
            this.$set('meta', data.meta);
        }).error(function (data, status, request) {
        });

        this.$http.get(resourceGalleryAlbumShow, function (data, status, request) {
            this.$set('album', data.data);
        }).error(function (data, status, request) {
        });
    },

    methods: {
        updateAlbum: function () {
            var resource = this.$resource(resourceGalleryAlbumUpdate);
            resource.update({id: this.album.slug}, {title: this.album.title}, function (data, status, request) {
            }).error(function (data, status, request) {
            });
        },
        addPhoto: function(photo) {
            this.photos.push(photo.data);
        }
    }
});


var dragAndDropModule = new fineUploader.DragAndDrop({
    dropZoneElements: [document.getElementById('photosGrid')],
    classes: {
        dropActive: "cssClassToAddToDropZoneOnEnter"
    },
    callbacks: {
        processingDroppedFilesComplete: function (files, dropTarget) {
            fineUploaderBasicInstanceImages.addFiles(files);
        }
    }
});

var fineUploaderBasicInstanceImages = new fineUploader.FineUploaderBasic({
    button: document.getElementById('uploadImageButton'),
    request: {
        endpoint: resourceGalleryAlbumPhotoStore,
        customHeaders: {
            "Authorization": "Bearer " + jwtoken
        },
        inputName: 'image'
    },
    validation: {
        allowedExtensions: ['jpeg', 'jpg', 'png', 'bmp']
    },
    callbacks: {
        onComplete: function (id, name, responseJSON) {
            VueInstance.addPhoto(responseJSON)
        },
        onUpload: function () {
            // $('#uploadButton').hide();
            // $('#uploadProgrssbar').show();
        },
        onTotalProgress: function (totalUploadedBytes, totalBytes) {
            $('#uploadProgrssbar').progress({
                percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
            });
        },
        onAllComplete: function (succeeded, failed) {
            /*    $('#uploadButton').show();
             $('#uploadProgrssbar').hide();
             $('#uploadProgrssbar').progress({
             percent: 0
             });
             */
        }
    }
});
