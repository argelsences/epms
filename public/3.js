(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[3],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=script&lang=js&":
/*!****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=script&lang=js& ***!
  \****************************************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var vue_recaptcha__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! vue-recaptcha */ "./node_modules/vue-recaptcha/dist/vue-recaptcha.es.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_1__);
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
  components: {
    VueRecaptcha: vue_recaptcha__WEBPACK_IMPORTED_MODULE_0__["default"]
  },
  props: ['department'],
  data: function data() {
    return {
      theDepartment: lodash__WEBPACK_IMPORTED_MODULE_1__["cloneDeep"](this.department),
      theMessage: this.message,
      errors: [],
      isSubmitting: false,
      submitted: false,
      myForm: null,
      captcha_site_key: "6LdZUggaAAAAABliaWc-JGsILqbIJQMUsq52DOeA",
      isValid: false,
      subscribe: {
        email: '',
        g_recaptcha_response: '',
        department_id: 0
      },
      message: '',
      rules: {
        required: function required(v) {
          return !!v || 'Required.';
        },
        maxMessage: function maxMessage(v) {
          return (v || '').length <= 255 || 'Text must be 255 characters or less';
        },
        maxName: function maxName(v) {
          return (v || '').length <= 80 || 'Text must be 80 characters or less';
        },
        emailValid: function emailValid(v) {
          return /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'E-mail must be valid';
        }
      }
    };
  },
  methods: {
    FormSubmit: function FormSubmit() {
      this.isSubmitting = true;
      this.$refs.recaptcha.execute();
    },
    onCaptchaVerified: function onCaptchaVerified(token) {
      var _this = this;

      this.resetCaptcha(); // append recaptcha token

      this.subscribe.g_recaptcha_response = token;
      this.subscribe.department_id = this.theDepartment.id;
      axios.post('/api/subscribe', this.subscribe).then(function (response) {
        if (response.data.success) {
          _this.errors = [];
        }

        _this.isSubmitting = false;
        _this.submitted = true;
        _this.message = response.data.message;

        _this.$nextTick(function () {
          // reset the form
          _this.$refs.form.reset();
        });
      })["catch"](function (err) {
        _this.isSubmitting = false;
        _this.errors = err.response.data.errors;
      });
    },
    resetCaptcha: function resetCaptcha() {
      this.$refs.recaptcha.reset();
    }
  },
  render: function render() {}
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.grecaptcha-badge[data-v-8e644c9e] {\n    visibility: hidden !important;\n}\n.subscribe-subtitle[data-v-8e644c9e] {margin:0 auto;}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css&":
/*!***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css& ***!
  \***************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--7-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=template&id=8e644c9e&scoped=true&":
/*!********************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=template&id=8e644c9e&scoped=true& ***!
  \********************************************************************************************************************************************************************************************************************************************************/
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
      _c(
        "v-card",
        { attrs: { flat: "" } },
        [
          _c("v-card-title", [
            _c(
              "div",
              { staticClass: "text--subtitle-1 subscribe-subtitle mb-5" },
              [_vm._v("And get the latest news and events from us.")]
            )
          ]),
          _vm._v(" "),
          _c(
            "v-card-subtitle",
            [
              _c(
                "v-alert",
                {
                  attrs: {
                    icon: "mdi-shield-lock-outline",
                    prominent: "",
                    text: "",
                    type: "info"
                  }
                },
                [
                  _vm._v(
                    "\n                By submitting this form, you expressly consent to our collection, use and storage of your personal data for the purposes of sending you program news, updates and events as per Personal Data Protection Act. If you wish to withdraw from the mailing list, please contact us at "
                  ),
                  _c("strong", [
                    _c(
                      "a",
                      { attrs: { href: "mailto:" + _vm.theDepartment.email } },
                      [_vm._v(_vm._s(_vm.theDepartment.email))]
                    )
                  ])
                ]
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-card-text",
            [
              _c(
                "v-container",
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12", sm: "12", md: "12" } },
                        [
                          _vm.submitted
                            ? _c(
                                "v-alert",
                                {
                                  attrs: {
                                    dense: "",
                                    outlined: "",
                                    type: "info"
                                  }
                                },
                                [_vm._v(_vm._s(_vm.message))]
                              )
                            : _vm._e()
                        ],
                        1
                      )
                    ],
                    1
                  ),
                  _vm._v(" "),
                  _c(
                    "v-form",
                    {
                      ref: "form",
                      model: {
                        value: _vm.isValid,
                        callback: function($$v) {
                          _vm.isValid = $$v
                        },
                        expression: "isValid"
                      }
                    },
                    [
                      _c(
                        "v-row",
                        [
                          _c(
                            "v-col",
                            { attrs: { cols: "12", sm: "12", md: "12" } },
                            [
                              _c("v-text-field", {
                                attrs: {
                                  label: "Email",
                                  rules: [
                                    _vm.rules.required,
                                    _vm.rules.emailValid
                                  ],
                                  "prepend-icon": "mdi-email"
                                },
                                model: {
                                  value: _vm.subscribe.email,
                                  callback: function($$v) {
                                    _vm.$set(_vm.subscribe, "email", $$v)
                                  },
                                  expression: "subscribe.email"
                                }
                              })
                            ],
                            1
                          )
                        ],
                        1
                      ),
                      _vm._v(" "),
                      _c(
                        "v-row",
                        [
                          _c("vue-recaptcha", {
                            ref: "recaptcha",
                            attrs: {
                              size: "invisible",
                              sitekey: _vm.captcha_site_key,
                              loadRecaptchaScript: true
                            },
                            on: {
                              verify: _vm.onCaptchaVerified,
                              expired: _vm.resetCaptcha
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
              )
            ],
            1
          ),
          _vm._v(" "),
          _c(
            "v-card-actions",
            [
              _c("v-spacer"),
              _vm._v(" "),
              _c("v-subheader", { staticClass: "red--text" }, [
                _vm._v("* All fields are required ")
              ]),
              _vm._v(" "),
              _c(
                "v-btn",
                {
                  staticClass: "white--text",
                  attrs: {
                    color: "blue darken-1",
                    disabled: !_vm.isValid || _vm.isSubmitting
                  },
                  on: { click: _vm.FormSubmit }
                },
                [_vm._v("SUBSCRIBE")]
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
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/front/departments/SubscribeDepartmentForm.vue":
/*!*******************************************************************************!*\
  !*** ./resources/js/components/front/departments/SubscribeDepartmentForm.vue ***!
  \*******************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SubscribeDepartmentForm_vue_vue_type_template_id_8e644c9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SubscribeDepartmentForm.vue?vue&type=template&id=8e644c9e&scoped=true& */ "./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=template&id=8e644c9e&scoped=true&");
/* harmony import */ var _SubscribeDepartmentForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SubscribeDepartmentForm.vue?vue&type=script&lang=js& */ "./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _SubscribeDepartmentForm_vue_vue_type_style_index_0_id_8e644c9e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css& */ "./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _SubscribeDepartmentForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SubscribeDepartmentForm_vue_vue_type_template_id_8e644c9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SubscribeDepartmentForm_vue_vue_type_template_id_8e644c9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "8e644c9e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/front/departments/SubscribeDepartmentForm.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=script&lang=js&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=script&lang=js& ***!
  \********************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./SubscribeDepartmentForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css&":
/*!****************************************************************************************************************************************!*\
  !*** ./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css& ***!
  \****************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_style_index_0_id_8e644c9e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--7-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=style&index=0&id=8e644c9e&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_style_index_0_id_8e644c9e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_style_index_0_id_8e644c9e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_style_index_0_id_8e644c9e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_style_index_0_id_8e644c9e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_style_index_0_id_8e644c9e_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=template&id=8e644c9e&scoped=true&":
/*!**************************************************************************************************************************!*\
  !*** ./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=template&id=8e644c9e&scoped=true& ***!
  \**************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_template_id_8e644c9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./SubscribeDepartmentForm.vue?vue&type=template&id=8e644c9e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/departments/SubscribeDepartmentForm.vue?vue&type=template&id=8e644c9e&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_template_id_8e644c9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SubscribeDepartmentForm_vue_vue_type_template_id_8e644c9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);