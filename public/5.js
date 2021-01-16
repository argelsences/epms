(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[5],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/Event.vue?vue&type=script&lang=js&":
/*!*****************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/events/Event.vue?vue&type=script&lang=js& ***!
  \*****************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _departments_Department_vue__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../departments/Department.vue */ "./resources/js/components/front/departments/Department.vue");
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//

/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    'departments': _departments_Department_vue__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  data: function data() {
    return {
      colors: ['indigo', 'warning', 'pink darken-2', 'red lighten-1', 'deep-purple accent-4'],

      /*
      slides: [
      'First',
      'Second',
      'Third',
      'Fourth',
      'Fifth',
      ],
      */
      base_url: window.location.origin,
      isLoading: false,
      slides: []
    };
  },
  methods: {
    initialize: function initialize() {
      var _this = this;

      axios.get('/api/latest-events').then(function (response) {
        _this.slides = response.data;
        _this.isLoading = false;
      });
    },
    setHedeaderTitle: function setHedeaderTitle() {
      document.title = 'Home - Event Publication and Poster Management System (EPPMS)';
    },
    theScreenshot: function theScreenshot(i) {
      var eventImage = '/images/eppms-default-poster.jpg';

      if (this.slides[i].poster) {
        eventImage = this.slides[i].poster.file_path || eventImage;
      }

      return eventImage;
    }
  },
  created: function created() {
    this.initialize();
    this.setHedeaderTitle();
  }
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css&":
/*!************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css& ***!
  \************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.event-screenshot[data-v-0d2aae96]{margin:0 auto;}\n.v-btn[data-v-0d2aae96]:hover{\n    transform: scale(1.15);\n    text-decoration: none;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css&":
/*!****************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--7-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/Event.vue?vue&type=template&id=0d2aae96&scoped=true&":
/*!*********************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/events/Event.vue?vue&type=template&id=0d2aae96&scoped=true& ***!
  \*********************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "v-app",
    [
      _c("v-divider"),
      _vm._v(" "),
      _c("div", { staticClass: "text-h4 text-center" }, [
        _vm._v("Latest Events")
      ]),
      _vm._v(" "),
      _c("v-divider"),
      _vm._v(" "),
      _c(
        "v-carousel",
        {
          attrs: {
            cycle: "",
            "hide-delimiter-background": "",
            "show-arrows-on-hover": ""
          }
        },
        _vm._l(_vm.slides, function(slide, i) {
          return _c(
            "v-carousel-item",
            { key: i },
            [
              _c(
                "v-sheet",
                { attrs: { color: _vm.colors[i], height: "100%" } },
                [
                  _c(
                    "v-row",
                    {
                      staticClass: "fill-height",
                      attrs: { align: "center", justify: "center" }
                    },
                    [
                      _c(
                        "v-col",
                        {
                          staticClass: "no-gutter",
                          attrs: { cols: "12", sm: "6", md: "6" }
                        },
                        [
                          _c(
                            "v-layout",
                            {
                              attrs: {
                                row: "",
                                wrap: "",
                                "align-center": "",
                                "fill-height": ""
                              }
                            },
                            [
                              _c(
                                "v-flex",
                                [
                                  _c("v-img", {
                                    staticClass: "event-screenshot",
                                    attrs: {
                                      "max-width": "300",
                                      src:
                                        _vm.base_url +
                                        "/" +
                                        _vm.theScreenshot(i)
                                    }
                                  })
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        {
                          staticClass: "fill-height pa-10 text-center",
                          attrs: { cols: "12", sm: "6", md: "6" }
                        },
                        [
                          _c("h3", [_vm._v(_vm._s(slide.title))]),
                          _c("br"),
                          _vm._v(" "),
                          _c("h5", [
                            _vm._v(
                              _vm._s(_vm._f("formatDate")(slide.start_date))
                            )
                          ]),
                          _vm._v(" "),
                          _c("h5", { staticClass: "pb-5" }, [
                            _vm._v(_vm._s(slide.venue.name))
                          ]),
                          _vm._v(" "),
                          _c("h6", [_vm._v(_vm._s(slide.excerpt))]),
                          _vm._v(" "),
                          _c(
                            "v-btn",
                            {
                              staticClass: "ma-5 white--text",
                              attrs: {
                                text: "",
                                ripple: "",
                                dark: "",
                                absolute: "",
                                bottom: "",
                                right: "",
                                href:
                                  _vm.base_url +
                                  "/d/" +
                                  slide.department.url +
                                  "/events/" +
                                  slide.id
                              }
                            },
                            [
                              _vm._v(
                                "\n                            View Event\n                            "
                              ),
                              _c("v-icon", [
                                _vm._v("mdi-chevron-right-circle-outline")
                              ])
                            ],
                            1
                          )
                        ],
                        1
                      )
                    ],
                    1
                  )
                ],
                1
              )
            ],
            1
          )
        }),
        1
      ),
      _vm._v(" "),
      _c("department")
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/front/events/Event.vue":
/*!********************************************************!*\
  !*** ./resources/js/components/front/events/Event.vue ***!
  \********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Event_vue_vue_type_template_id_0d2aae96_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Event.vue?vue&type=template&id=0d2aae96&scoped=true& */ "./resources/js/components/front/events/Event.vue?vue&type=template&id=0d2aae96&scoped=true&");
/* harmony import */ var _Event_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Event.vue?vue&type=script&lang=js& */ "./resources/js/components/front/events/Event.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _Event_vue_vue_type_style_index_0_id_0d2aae96_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css& */ "./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Event_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Event_vue_vue_type_template_id_0d2aae96_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Event_vue_vue_type_template_id_0d2aae96_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "0d2aae96",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/front/events/Event.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/front/events/Event.vue?vue&type=script&lang=js&":
/*!*********************************************************************************!*\
  !*** ./resources/js/components/front/events/Event.vue?vue&type=script&lang=js& ***!
  \*********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Event.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/Event.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css&":
/*!*****************************************************************************************************************!*\
  !*** ./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css& ***!
  \*****************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_style_index_0_id_0d2aae96_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--7-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/Event.vue?vue&type=style&index=0&id=0d2aae96&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_style_index_0_id_0d2aae96_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_style_index_0_id_0d2aae96_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_style_index_0_id_0d2aae96_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_style_index_0_id_0d2aae96_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_style_index_0_id_0d2aae96_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/front/events/Event.vue?vue&type=template&id=0d2aae96&scoped=true&":
/*!***************************************************************************************************!*\
  !*** ./resources/js/components/front/events/Event.vue?vue&type=template&id=0d2aae96&scoped=true& ***!
  \***************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_template_id_0d2aae96_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./Event.vue?vue&type=template&id=0d2aae96&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/Event.vue?vue&type=template&id=0d2aae96&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_template_id_0d2aae96_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Event_vue_vue_type_template_id_0d2aae96_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);