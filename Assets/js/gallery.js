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

	var _Album = __webpack_require__(4);

	var _Album2 = _interopRequireDefault(_Album);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	new Vue({
	    el: '#societyAdmin',
	    data: {
	        gallery: null,
	        meta: null,
	        newAlbum: {
	            title: null,
	            description: null
	        }
	    },
	    components: { Album: _Album2.default },
	    ready: function ready() {
	        this.$http.get(resourceGalleryAlbumIndex, function (data, status, request) {
	            this.$set('gallery', data.data);
	            this.$set('meta', data.meta);
	        }).error(function (data, status, request) {});
	    },

	    methods: {
	        newAlbumModal: function newAlbumModal() {
	            $('#newAlbumModal').modal('setting', 'transition', 'fade up').modal('show');
	        },
	        createNewAlbum: function createNewAlbum() {
	            var resource = this.$resource(resourceGalleryAlbumStore);

	            resource.save(this.newAlbum, function (data, status, request) {}).error(function (data, status, request) {});
	        }
	    }
	});

/***/ },
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(5)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] Resources/assets/js/components/Album.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(6)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), true)
	  if (!hotAPI.compatible) return
	  var id = "/home/ralph/webDev/societycms/modules/Gallery/Resources/assets/js/components/Album.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 5 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['album']
	};

/***/ },
/* 6 */
/***/ function(module, exports) {

	module.exports = "\n<a class=\"card\" href=\"{{album.links.backend}}\">\n    <div class=\"image\">\n        <div class=\"ui blue right corner label\" v-if=\"album.published\">\n            <i class=\"bookmark icon\"></i>\n        </div>\n        <img v-bind:src=\"album.cover.data.thumbnail.cover\" >\n    </div>\n    <div class=\"content\">\n        <div class=\"header\">{{ album.title }}</div>\n    </div>\n    <div class=\"extra content\">\n        <i class=\"photo icon\"></i>\n        {{ album.photos.total }} Photos\n    </div>\n</a>\n";

/***/ }
/******/ ]);