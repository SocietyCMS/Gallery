webpackJsonp([1],[
/* 0 */,
/* 1 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(2)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] Resources/assets/components/index.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(6)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  var id = "./index.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 2 */
/***/ function(module, exports, __webpack_require__) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});

	var _Album = __webpack_require__(3);

	var _Album2 = _interopRequireDefault(_Album);

	function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

	exports.default = {

	    components: {
	        Album: _Album2.default
	    },

	    props: {},

	    data: function data() {
	        return {
	            galleries: []
	        };
	    },


	    ready: function ready() {
	        this.$http.get(societycms.api.gallery.album.index, function (data, status, request) {
	            this.$set('galleries', data.data);
	        }).error(function (data, status, request) {});
	    },

	    methods: {}
	};

/***/ },
/* 3 */
/***/ function(module, exports, __webpack_require__) {

	var __vue_script__, __vue_template__
	__vue_script__ = __webpack_require__(4)
	if (__vue_script__ &&
	    __vue_script__.__esModule &&
	    Object.keys(__vue_script__).length > 1) {
	  console.warn("[vue-loader] Resources/assets/components/Album.vue: named exports in *.vue files are ignored.")}
	__vue_template__ = __webpack_require__(5)
	module.exports = __vue_script__ || {}
	if (module.exports.__esModule) module.exports = module.exports.default
	if (__vue_template__) {
	(typeof module.exports === "function" ? (module.exports.options || (module.exports.options = {})) : module.exports).template = __vue_template__
	}
	if (false) {(function () {  module.hot.accept()
	  var hotAPI = require("vue-hot-reload-api")
	  hotAPI.install(require("vue"), false)
	  if (!hotAPI.compatible) return
	  var id = "./Album.vue"
	  if (!module.hot.data) {
	    hotAPI.createRecord(id, module.exports)
	  } else {
	    hotAPI.update(id, module.exports, __vue_template__)
	  }
	})()}

/***/ },
/* 4 */
/***/ function(module, exports) {

	'use strict';

	Object.defineProperty(exports, "__esModule", {
	    value: true
	});
	exports.default = {
	    props: ['album']
	};

/***/ },
/* 5 */
/***/ function(module, exports) {

	module.exports = "\n<a class=\"card\" v-link=\"{ name: 'show', params: { slug: album.slug }}\">\n    <div class=\"image\">\n        <div class=\"ui green right corner label\" v-if=\"album.published\">\n            <i class=\"bookmark icon\"></i>\n        </div>\n        <div class=\"ui yellow right corner label\" v-if=\"!album.published\">\n            <i class=\"write icon\"></i>\n        </div>\n        <img v-bind:src=\"album.cover.data.thumbnail.square\" v-if=\"album.cover\">\n        <img src=\"/modules/gallery/images/no-preview.png\" v-else>\n    </div>\n    <div class=\"content\">\n        <div class=\"header\">{{ album.title }}</div>\n    </div>\n    <div class=\"extra content\">\n        <i class=\"photo icon\"></i>\n        {{ album.photos.total }}\n    </div>\n</a>\n";

/***/ },
/* 6 */
/***/ function(module, exports) {

	module.exports = "\n<a class=\"ui primary button\" >\n    <i class=\"add user icon\"></i>\n</a>\n\n<div class=\"ui six doubling link cards gallery\">\n    <album :album=\"album\" v-for=\"album in galleries\"></album>\n</div>\n";

/***/ }
]);