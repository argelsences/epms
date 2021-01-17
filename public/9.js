(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[9],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/AdminTemplate.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/AdminTemplate.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
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
  props: {
    source: String
  },
  data: function data() {
    return {
      drawer: null,
      expandOnHover: true,
      profile: {
        department: {
          url: '',
          name: ''
        }
      },
      base_url: window.location.origin + '/',
      isSuperAdmin: false
    };
  },
  watch: {
    '$route': function $route(to, from) {
      document.title = to.meta.title + ' - Event Publication and Poster Management System (EPPMS)' || false;
    }
  },
  methods: {
    getProfile: function getProfile() {
      var _this = this;

      axios.get('/api/profile').then(function (response) {
        //this.profile = response.data
        _this.setUserProfile(response.data);

        if (_this.profile.roles[0].name === 'Super Administrator') _this.isSuperAdmin = true;
        console.log(_this.profile);
      });
    },
    setUserProfile: function setUserProfile(userProfile) {
      this.profile = userProfile;
    }
  },
  created: function created() {
    this.getProfile();
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/AdminTemplate.vue?vue&type=template&id=36e0e0e4&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/admin/AdminTemplate.vue?vue&type=template&id=36e0e0e4& ***!
  \**********************************************************************************************************************************************************************************************************************/
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
    { attrs: { id: "inspire" } },
    [
      _c(
        "v-navigation-drawer",
        {
          attrs: {
            app: "",
            "expand-on-hover": _vm.expandOnHover,
            "mobile-breakpoint": "800"
          },
          scopedSlots: _vm._u([
            {
              key: "prepend",
              fn: function() {
                return [
                  _c(
                    "v-list",
                    { attrs: { dense: "" } },
                    [
                      _c(
                        "v-list-item",
                        [
                          _c(
                            "v-list-item-action",
                            [
                              _c("v-icon", [
                                _vm._v("mdi-account-circle-outline")
                              ])
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _c(
                            "v-list-item-content",
                            [
                              _c(
                                "v-list-item-title",
                                [
                                  _c(
                                    "div",
                                    {
                                      staticClass: "text-subtitle-2 text-left"
                                    },
                                    [
                                      _vm._v(
                                        "\n                " +
                                          _vm._s(_vm.profile.name) +
                                          "\n              "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "div",
                                    { staticClass: "text-caption text-left" },
                                    [
                                      _vm._v(
                                        "\n                " +
                                          _vm._s(_vm.profile.designation) +
                                          "\n              "
                                      )
                                    ]
                                  ),
                                  _vm._v(" "),
                                  _c(
                                    "v-btn",
                                    {
                                      attrs: {
                                        "x-small": "",
                                        color: "cyan darken-2",
                                        tile: "",
                                        outlined: ""
                                      }
                                    },
                                    [
                                      _vm._v(
                                        "\n                Profile\n              "
                                      )
                                    ]
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
                  ),
                  _vm._v(" "),
                  _c("v-divider")
                ]
              },
              proxy: true
            }
          ]),
          model: {
            value: _vm.drawer,
            callback: function($$v) {
              _vm.drawer = $$v
            },
            expression: "drawer"
          }
        },
        [
          _c(
            "v-list",
            { attrs: { dense: "" } },
            [
              _c(
                "v-list-item",
                { attrs: { link: "", to: { name: "dashboard" } } },
                [
                  _c(
                    "v-list-item-action",
                    [_c("v-icon", [_vm._v("mdi-view-dashboard-outline")])],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-list-item-content",
                    [_c("v-list-item-title", [_vm._v("Dashboard")])],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item",
                { attrs: { link: "", to: { name: "events" } } },
                [
                  _c(
                    "v-list-item-action",
                    [_c("v-icon", [_vm._v("mdi-calendar")])],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-list-item-content",
                    [_c("v-list-item-title", [_vm._v("Events")])],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item",
                { attrs: { link: "", to: { name: "posters" } } },
                [
                  _c(
                    "v-list-item-action",
                    [_c("v-icon", [_vm._v("mdi-file-image-outline")])],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-list-item-content",
                    [_c("v-list-item-title", [_vm._v("Posters")])],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item",
                { attrs: { link: "", to: { name: "speakers" } } },
                [
                  _c(
                    "v-list-item-action",
                    [_c("v-icon", [_vm._v("mdi-bullhorn")])],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-list-item-content",
                    [_c("v-list-item-title", [_vm._v("Speakers")])],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item",
                { attrs: { link: "", to: { name: "venues" } } },
                [
                  _c(
                    "v-list-item-action",
                    [_c("v-icon", [_vm._v("mdi-map-marker")])],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-list-item-content",
                    [_c("v-list-item-title", [_vm._v("Venues")])],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item",
                { attrs: { link: "", to: { name: "templates" } } },
                [
                  _c(
                    "v-list-item-action",
                    [_c("v-icon", [_vm._v("mdi-panorama")])],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-list-item-content",
                    [_c("v-list-item-title", [_vm._v("Templates")])],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item",
                { attrs: { link: "", to: { name: "departments" } } },
                [
                  _c(
                    "v-list-item-action",
                    [_c("v-icon", [_vm._v("mdi-office-building")])],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-list-item-content",
                    [_c("v-list-item-title", [_vm._v("Departments")])],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-list-item",
                { attrs: { link: "", to: { name: "users" } } },
                [
                  _c(
                    "v-list-item-action",
                    [_c("v-icon", [_vm._v("mdi-account-multiple")])],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-list-item-content",
                    [_c("v-list-item-title", [_vm._v("Users")])],
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
      ),
      _vm._v(" "),
      _c(
        "v-app-bar",
        { staticClass: "cyan darken-4", attrs: { app: "", dark: "" } },
        [
          _c(
            "v-toolbar-title",
            [
              _vm.isSuperAdmin
                ? _c(
                    "v-btn",
                    {
                      staticClass: "ma-2 text-h5",
                      attrs: {
                        text: "",
                        dark: "",
                        href: "" + _vm.base_url,
                        target: "_blank"
                      }
                    },
                    [
                      _vm._v("\n          EPPMS\n        "),
                      _c("v-icon", { attrs: { dark: "", right: "" } }, [
                        _vm._v("\n          mdi-home\n        ")
                      ])
                    ],
                    1
                  )
                : _c(
                    "v-btn",
                    {
                      staticClass: "ma-2 text-h5",
                      attrs: {
                        text: "",
                        dark: "",
                        href: _vm.base_url + "d/" + _vm.profile.department.url,
                        target: "_blank"
                      }
                    },
                    [
                      _vm._v(
                        "\n          " +
                          _vm._s(_vm.profile.department.name) +
                          "\n        "
                      ),
                      _c("v-icon", { attrs: { dark: "", right: "" } }, [
                        _vm._v("\n          mdi-home\n        ")
                      ])
                    ],
                    1
                  )
            ],
            1
          ),
          _vm._v(" "),
          _c("v-spacer"),
          _vm._v(" "),
          _c(
            "v-btn",
            { attrs: { to: { name: "settings" }, icon: "" } },
            [_c("v-icon", [_vm._v("mdi-cogs")])],
            1
          ),
          _vm._v(" "),
          _c(
            "v-btn",
            {
              attrs: {
                onclick:
                  "event.preventDefault();document.getElementById('logout-form').submit();",
                icon: ""
              }
            },
            [_c("v-icon", [_vm._v("mdi-exit-run")])],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-main",
        [
          _c(
            "v-container",
            { staticClass: "fill-height", attrs: { fluid: "" } },
            [
              _c(
                "v-row",
                { attrs: { align: "center", justify: "center" } },
                [
                  _c(
                    "v-col",
                    { staticClass: "text-center" },
                    [_c("router-view")],
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
      ),
      _vm._v(" "),
      _c(
        "v-footer",
        { staticClass: "cyan darken-4", attrs: { app: "", dark: "" } },
        [
          _c("span", { staticClass: "white--text" }, [
            _vm._v("© " + _vm._s(new Date().getFullYear()))
          ])
        ]
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/admin/AdminTemplate.vue":
/*!*********************************************************!*\
  !*** ./resources/js/components/admin/AdminTemplate.vue ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _AdminTemplate_vue_vue_type_template_id_36e0e0e4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./AdminTemplate.vue?vue&type=template&id=36e0e0e4& */ "./resources/js/components/admin/AdminTemplate.vue?vue&type=template&id=36e0e0e4&");
/* harmony import */ var _AdminTemplate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./AdminTemplate.vue?vue&type=script&lang=js& */ "./resources/js/components/admin/AdminTemplate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _AdminTemplate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _AdminTemplate_vue_vue_type_template_id_36e0e0e4___WEBPACK_IMPORTED_MODULE_0__["render"],
  _AdminTemplate_vue_vue_type_template_id_36e0e0e4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/admin/AdminTemplate.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/admin/AdminTemplate.vue?vue&type=script&lang=js&":
/*!**********************************************************************************!*\
  !*** ./resources/js/components/admin/AdminTemplate.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AdminTemplate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./AdminTemplate.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/AdminTemplate.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_AdminTemplate_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/admin/AdminTemplate.vue?vue&type=template&id=36e0e0e4&":
/*!****************************************************************************************!*\
  !*** ./resources/js/components/admin/AdminTemplate.vue?vue&type=template&id=36e0e0e4& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AdminTemplate_vue_vue_type_template_id_36e0e0e4___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./AdminTemplate.vue?vue&type=template&id=36e0e0e4& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/admin/AdminTemplate.vue?vue&type=template&id=36e0e0e4&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AdminTemplate_vue_vue_type_template_id_36e0e0e4___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_AdminTemplate_vue_vue_type_template_id_36e0e0e4___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);