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
/******/ 	__webpack_require__.p = "";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = "./resources/js/maps.js");
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/maps.js":
/*!******************************!*\
  !*** ./resources/js/maps.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("window.Vue.component(\"google-maps-widget\",\n{\n    template: `<div :class=\"aspectRatio\" class=\"maps-component\" ref=\"googleMapsContainer\"></div>`,\n\n    props:\n    {\n        googleApiKey:\n        {\n            type: String,\n            required: true\n        },\n        address:\n        {\n            type: String,\n            required: false\n        },\n        lat:\n        {\n            type: Number\n        },\n        lng:\n        {\n            type: Number\n        },\n        zoom:\n        {\n            type: Number,\n            default: 16\n        },\n        aspectRatio:\n        {\n            type: String,\n            default: \"map-3-1\",\n            validator: value =>\n            {\n                return [\"map-3-1\", \"map-2-1\", \"map-1-1\", \"\"].indexOf(value) !== -1\n            }\n        }\n    },\n\n    computed:\n    {\n        coordinates()\n        {\n            const isLatValid = !isNaN(this.lat) && this.lat > -90 && this.lat < 90\n            const isLngValid = !isNaN(this.lng) && this.lng > -180 && this.lng < 180\n\n            if (isLatValid && isLngValid)\n            {\n                return {\n                    lat: this.lat,\n                    lng: this.lng\n                }\n            }\n\n            return null\n        }\n    },\n\n    mounted()\n    {\n        this.$nextTick(() =>\n        {\n            if (!document.querySelector(\"#google-maps-api\"))\n            {\n                this.createScript().then(() => this.initializeMap())\n            }\n            else\n            {\n                this.listenToExistingScript()\n            }\n        })\n    },\n\n    methods:\n    {\n        createScript()\n        {\n            return new Promise((resolve, reject) =>\n            {\n                const script = document.createElement(\"script\")\n                const scriptSource = `https://maps.googleapis.com/maps/api/js?key=${this.googleApiKey}`\n\n                script.type = \"text/javascript\"\n                script.id = \"google-maps-api\"\n                script.src = scriptSource\n\n                script.addEventListener(\"load\", () => resolve(script), false)\n                script.addEventListener(\"error\", () => reject(script), false)\n\n                document.body.appendChild(script)\n            })\n        },\n\n        listenToExistingScript()\n        {\n            const script = document.querySelector(\"script#google-maps-api\")\n            \n            if (typeof google === \"undefined\")\n            {\n                script.addEventListener(\"load\", () => this.initializeMap(), false)\n            }\n            else\n            {\n                this.initializeMap()\n            }\n        },\n\n        initializeMap()\n        {\n            if (this.coordinates)\n            {\n                this.renderMap(this.coordinates)\n            }\n            else\n            {\n                this.geocodeAddress().then(coordinates =>\n                    {\n                        this.renderMap(coordinates)\n                    });\n            }\n        },\n\n        geocodeAddress()\n        {\n            return new Promise((resolve, reject) =>\n            {\n                new google.maps.Geocoder().geocode({ address: this.address }, (results, status) =>\n                {\n                    if (status === google.maps.GeocoderStatus.OK)\n                    {\n                        resolve({\n                            lat: results[0].geometry.location.lat(),\n                            lng: results[0].geometry.location.lng()\n                        })\n                    }\n                    else\n                    {\n                        reject()\n                    }\n                })\n            })\n        },\n\n        renderMap(coordinates)\n        {\n            const map = new google.maps.Map(this.$refs.googleMapsContainer,\n                {\n                    center: coordinates,\n                    zoom  : this.zoom\n                })\n\n            new google.maps.Marker(\n                {\n                    map: map,\n                    position: coordinates\n                })\n        }\n    }\n})\n\n\n//# sourceURL=webpack:///./resources/js/maps.js?");

/***/ })

/******/ });