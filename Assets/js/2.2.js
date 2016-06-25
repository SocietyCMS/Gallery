webpackJsonp([2],[
/* 0 */,
/* 1 */,
/* 2 */,
/* 3 */,
/* 4 */,
/* 5 */,
/* 6 */,
/* 7 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(8)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] Resources/assets/components/show.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(12)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  var id = "./show.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 8 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _Photo = __webpack_require__(9);

	var _Photo2 = _interopRequireDefault(_Photo);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = {

	    components: {
	        Photo: _Photo2.default
	    },

	    props: {},

	    data: function data() {
	        return {
	            photos: []
	        };
	    },


	    ready: function ready() {
	        this.$http.get(societycms.api.gallery.album.photo.index, { album: $route.params.slug }, function (data, status, request) {
	            this.$set('photos', data.data);
	        }).error(function (data, status, request) {});
	    },

	    methods: {}
	};

/***/ },
/* 9 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(10)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] Resources/assets/components/Photo.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(11)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  var id = "./Photo.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 10 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['photo'],
	    computed: {
	        thumbnailImage: function thumbnailImage() {
	            if (this.photo.thumbnail && this.photo.thumbnail.medium) {
	                return this.photo.thumbnail.medium;
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
/* 11 */
/***/ function(module, exports) {

	module.exports = "\n<div class=\"photo\" data-w=\"{{photo.properties.width}}\" data-h=\"{{photo.properties.height}}\" @click=\"showDetails\">\n    <img id=\"photo-id-{{photo.id}}\" class=\"ui rounded image\"\n         v-bind:style=\"{ height: thumbnailHeight, width: thumbnailWidth}\"\n         v-bind:data-src=\"thumbnailImage\">\n    <div class=\"ui active dimmer\" v-if=\"photo.preview\">\n        <div class=\"ui indeterminate loader\"></div>\n    </div>\n</div>\n";

/***/ },
/* 12 */
/***/ function(module, exports) {

	module.exports = "\n<photo :photo=\"photo\" v-for=\"photo in photos\"></photo>\n";

/***/ }
]);