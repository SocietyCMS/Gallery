import Photo from './components/Photo.vue';

var VueInstance = new Vue({
    el: '#societyAdmin',
    data: {
        photos: null,
        album: {
            title: null
        },
        meta: null,
        deleting: false
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
        addPhoto: function(previewID, previewName, photo) {
            var index = this.photos.map(function(e) { return e.id; }).indexOf(previewID);
            this.photos.$set(index,photo.data);
        },
        addPreview: function(previewID, previewName) {
            this.album.photos.total++;
            return this.photos.push({
                id: previewID,
                preview: {
                    name: previewName
                }
            });
        },
        deleteAlbumModal: function() {
            $('#deleteAlbumModal')
                .modal('setting', 'transition', 'fade up')
                .modal('show');
        },
        deleteAlbum: function() {

            $('#deleteAlbumModal')
                .modal('hide');

            this.deleting = true;
            var resource = this.$resource(resourceGalleryAlbumDelete);

            resource.delete(this.album, function (data, status, request) {
                window.open(backendGalleryAlbumIndex,"_self")
            }).error(function (data, status, request) {
            });


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
    enableAuto: true,
    maxConnections: 1,
    callbacks: {
        onComplete: function (id, name, responseJSON) {
            VueInstance.addPhoto('#'+id, name, responseJSON)
        },
        onSubmitted: function (id, name) {
            VueInstance.addPreview('#'+id, name);
            Vue.nextTick(function () {
                return fineUploaderBasicInstanceImages.drawThumbnail(id,document.getElementById('photo-id-#'+id), 225);
            }.bind(this))
        },
        onTotalProgress: function (totalUploadedBytes, totalBytes) {
            $('#uploadProgrssbar').progress({
                percent: Math.ceil(totalUploadedBytes / totalBytes * 100)
            });
        },
        onError: function (id, name, errorReason) {
            // toastr.error(errorReason, 'Error: ' + name);
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
