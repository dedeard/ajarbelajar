/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/admin.js":
/*!*******************************!*\
  !*** ./resources/js/admin.js ***!
  \*******************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _admin_components_AppSidebar__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./admin/components/AppSidebar */ "./resources/js/admin/components/AppSidebar.js");
/* harmony import */ var _admin_components_AppAlert__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./admin/components/AppAlert */ "./resources/js/admin/components/AppAlert.js");
/* harmony import */ var _admin_directives_Sidebar__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./admin/directives/Sidebar */ "./resources/js/admin/directives/Sidebar.js");



var Vue = window.Vue;
Vue.directive('toggle-sidebar', _admin_directives_Sidebar__WEBPACK_IMPORTED_MODULE_2__["toggleSidebar"]);
Vue.directive('open-sidebar', _admin_directives_Sidebar__WEBPACK_IMPORTED_MODULE_2__["openSidebar"]);
Vue.directive('close-sidebar', _admin_directives_Sidebar__WEBPACK_IMPORTED_MODULE_2__["closeSidebar"]);
Vue.component('AppSidebar', _admin_components_AppSidebar__WEBPACK_IMPORTED_MODULE_0__["default"]);
Vue.component('AppAlert', _admin_components_AppAlert__WEBPACK_IMPORTED_MODULE_1__["default"]);
new Vue({
  el: '#app'
});

/***/ }),

/***/ "./resources/js/admin/components/AppAlert.js":
/*!***************************************************!*\
  !*** ./resources/js/admin/components/AppAlert.js ***!
  \***************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      open: true
    };
  },
  methods: {
    close: function close() {
      this.open = false;
    }
  }
});

/***/ }),

/***/ "./resources/js/admin/components/AppSidebar.js":
/*!*****************************************************!*\
  !*** ./resources/js/admin/components/AppSidebar.js ***!
  \*****************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony default export */ __webpack_exports__["default"] = ({
  data: function data() {
    return {
      elSidebarScroll: null,
      elSidebarScrollStyle: null,
      sidebarPs: null,
      open: false
    };
  },
  methods: {
    sidebarScroll: function sidebarScroll() {
      console.log(this.elSidebarScrollStyle.getPropertyValue('overflow-y'));

      if (this.elSidebarScrollStyle.getPropertyValue('overflow-y') != 'auto') {
        if (!this.sidebarPs) {
          this.sidebarPs = new window.PerfectScrollbar(this.elSidebarScroll);
        }
      } else {
        if (this.sidebarPs) {
          this.sidebarPs.destroy();
          this.sidebarPs = null;
        }
      }
    }
  },
  mounted: function mounted() {
    this.elSidebarScroll = this.$refs.elSidebarScroll;
    this.elSidebarScrollStyle = window.getComputedStyle(this.elSidebarScroll);
    this.sidebarScroll();
    window.onresize = this.sidebarScroll;
  }
});

/***/ }),

/***/ "./resources/js/admin/directives/Sidebar.js":
/*!**************************************************!*\
  !*** ./resources/js/admin/directives/Sidebar.js ***!
  \**************************************************/
/*! exports provided: toggleSidebar, openSidebar, closeSidebar */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "toggleSidebar", function() { return toggleSidebar; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "openSidebar", function() { return openSidebar; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "closeSidebar", function() { return closeSidebar; });
var toggleSidebar = {
  bind: function bind(el) {
    el.addEventListener('click', function (ev) {
      ev.preventDefault();
      document.querySelector('body').classList.toggle('sidebar-open');
    });
  }
};
var openSidebar = {
  bind: function bind(el) {
    el.addEventListener('click', function (ev) {
      ev.preventDefault();
      document.querySelector('body').classList.add('sidebar-open');
    });
  }
};
var closeSidebar = {
  bind: function bind(el) {
    el.addEventListener('click', function (ev) {
      ev.preventDefault();
      document.querySelector('body').classList.remove('sidebar-open');
    });
  }
};

/***/ }),

/***/ 3:
/*!*************************************!*\
  !*** multi ./resources/js/admin.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! X:\project\ajarbelajar\resources\js\admin.js */"./resources/js/admin.js");


/***/ })

/******/ });