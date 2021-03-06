import Photo from './components/Photo.vue';

require('../less/Gallery.less');

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
        this.$http.get(societycms.api.gallery.album.photo.index, {album:societycms.gallery.album.slug}, function (data, status, request) {
            this.$set('photos', data.data);
            this.$set('meta', data.meta);
        }).error(function (data, status, request) {
        });

        this.$http.get(societycms.api.gallery.album.show, {album:societycms.gallery.album.slug}, function (data, status, request) {
            this.$set('album', data.data);           
        }).error(function (data, status, request) {
        });
    },

    methods: {
        updateAlbum: function () {
            var resource = this.$resource(societycms.api.gallery.album.update);
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
            var resource = this.$resource(societycms.api.gallery.album.destroy);

            resource.delete({album:societycms.gallery.album.slug}, this.album, function (data, status, request) {
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
            toastr.info('Uploading '+files.length+' files. Please wait..');
            fineUploaderBasicInstanceImages.addFiles(files);
        }
    }
});

var fineUploaderBasicInstanceImages = new fineUploader.FineUploaderBasic({
    button: document.getElementById('uploadImageButton'),
    request: {
        endpoint: Vue.url(societycms.api.gallery.album.photo.store, {album:societycms.gallery.album.slug}),
        customHeaders: {
            "Authorization": "Bearer " + societycms.jwtoken
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
        },
        onError: function (id, name, errorReason) {
             toastr.error(errorReason, 'Error: ' + name);
        },
        onAllComplete: function (succeeded, failed) {
            console.log(succeeded, failed);
            toastr.success('Upload successful');
        }
    }
});
