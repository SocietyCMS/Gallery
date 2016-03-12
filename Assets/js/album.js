/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};

/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {

/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId])
/******/ 			return installedModules[moduleId].exports;

/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			exports: {},
/******/ 			id: moduleId,
/******/ 			loaded: false
/******/ 		};

/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);

/******/ 		// Flag the module as loaded
/******/ 		module.loaded = true;

/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}


/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;

/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;

/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";

/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	var _Photo = __webpack_require__(1);

	var _Photo2 = _interopRequireDefault(_Photo);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

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
	    components: { Photo: _Photo2.default },
	    ready: function ready() {
	        this.$http.get(resourceGalleryAlbumPhotoIndex, function (data, status, request) {
	            this.$set('photos', data.data);
	            this.$set('meta', data.meta);
	        }).error(function (data, status, request) {});

	        this.$http.get(resourceGalleryAlbumShow, function (data, status, request) {
	            this.$set('album', data.data);
	        }).error(function (data, status, request) {});
	    },

	    methods: {
	        updateAlbum: function updateAlbum() {
	            var resource = this.$resource(resourceGalleryAlbumUpdate);
	            resource.update({ id: this.album.slug }, { title: this.album.title }, function (data, status, request) {}).error(function (data, status, request) {});
	        },
	        addPhoto: function addPhoto(previewID, previewName, photo) {
	            var index = this.photos.map(function (e) {
	                return e.id;
	            }).indexOf(previewID);
	            this.photos.$set(index, photo.data);
	        },
	        addPreview: function addPreview(previewID, previewName) {
	            this.album.photos.total++;
	            return this.photos.push({
	                id: previewID,
	                preview: {
	                    name: previewName
	                }
	            });
	        },
	        deleteAlbumModal: function deleteAlbumModal() {
	            $('#deleteAlbumModal').modal('setting', 'transition', 'fade up').modal('show');
	        },
	        deleteAlbum: function deleteAlbum() {

	            $('#deleteAlbumModal').modal('hide');

	            this.deleting = true;
	            var resource = this.$resource(resourceGalleryAlbumDelete);

	            resource.delete(this.album, function (data, status, request) {
	                window.open(backendGalleryAlbumIndex, "_self");
	            }).error(function (data, status, request) {});
	        }
	    }
	});

	var dragAndDropModule = new fineUploader.DragAndDrop({
	    dropZoneElements: [document.getElementById('photosGrid')],
	    classes: {
	        dropActive: "cssClassToAddToDropZoneOnEnter"
	    },
	    callbacks: {
	        processingDroppedFilesComplete: function processingDroppedFilesComplete(files, dropTarget) {
	            toastr.info('Uploading ' + files.length + ' files. Please wait..');
	            fineUploaderBasicInstanceImages.addFiles(files);
	        }
	    }
	});

	var fineUploaderBasicInstanceImages = new fineUploader.FineUploaderBasic({
	    button: document.getElementById('uploadImageButton'),
	    request: {
	        endpoint: resourceGalleryAlbumPhotoStore,
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
	        onComplete: function onComplete(id, name, responseJSON) {
	            VueInstance.addPhoto('#' + id, name, responseJSON);
	        },
	        onSubmitted: function onSubmitted(id, name) {
	            VueInstance.addPreview('#' + id, name);
	            Vue.nextTick(function () {
	                return fineUploaderBasicInstanceImages.drawThumbnail(id, document.getElementById('photo-id-#' + id), 225);
	            }.bind(this));
	        },
	        onTotalProgress: function onTotalProgress(totalUploadedBytes, totalBytes) {},
	        onError: function onError(id, name, errorReason) {
	            toastr.error(errorReason, 'Error: ' + name);
	        },
	        onAllComplete: function onAllComplete(succeeded, failed) {
	            console.log(succeeded, failed);
	            toastr.success('Upload successful');
	        }
	    }
	});

/***/ },
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(2)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] Resources/assets/js/components/Photo.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(3)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "/home/ralph/webDev/societycms/modules/Gallery/Resources/assets/js/components/Photo.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 2 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['photo'],
	    computed: {
	        thumbnailImage: function thumbnailImage() {
	            if (this.photo.thumbnail && this.photo.thumbnail.large) {
	                return this.photo.thumbnail.large;
	            }
	        },
	        thumbnailHeight: function thumbnailHeight() {
	            return '225px';
	        },
	        thumbnailWidth: function thumbnailWidth() {
	            if (this.photo.properties && this.photo.properties.height && this.photo.properties.width) {
	                return Math.ceil(225 / this.photo.properties.height * this.photo.properties.width) + 'px';
	            }
	        }
	    },
	    ready: function ready() {
	        Vue.nextTick(function () {
	            $('#photo-id-' + this.photo.id).visibility({
	                type: 'image',
	                transition: 'fade in',
	                duration: 1000
	            });
	        }.bind(this));
	    }
	};

/***/ },
/* 3 */
/***/ function(module, exports) {

	module.exports = "\n<div class=\"photo\">\n    <img id=\"photo-id-{{photo.id}}\" class=\"ui rounded image\" v-bind:style=\"{ height: thumbnailHeight, width: thumbnailWidth}\"\n         v-bind:data-src=\"thumbnailImage\">\n    <div class=\"ui active dimmer\" v-if=\"photo.preview\">\n        <div class=\"ui indeterminate loader\"></div>\n    </div>\n</div>\n";

/***/ }
/******/ ]);