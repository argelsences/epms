(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[10],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/TicketForm.vue?vue&type=script&lang=js&":
/*!**********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/events/TicketForm.vue?vue&type=script&lang=js& ***!
  \**********************************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash */ "./node_modules/lodash/lodash.js");
/* harmony import */ var lodash__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! moment */ "./node_modules/moment/moment.js");
/* harmony import */ var moment__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(moment__WEBPACK_IMPORTED_MODULE_1__);
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
  props: ['event'],
  mounted: function mounted() {
    var numberTickets = this.numberTickets;
    console.log(this.theEvent.tickets);
    this.theEvent.tickets.forEach(function (ticket) {
      //console.log(numberTickets.length)
      for (var i = 0; i < numberTickets; i++) {//console.log(ticket)
      }
    });
  },
  data: function data() {
    return {
      theEvent: lodash__WEBPACK_IMPORTED_MODULE_0___default.a.cloneDeep(this.event),
      errors: [],
      isSubmitting: false,
      submitted: false,
      myForm: null,
      captcha_site_key: "6LdZUggaAAAAABliaWc-JGsILqbIJQMUsq52DOeA",
      isValid: false,
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
      },
      step: 1,
      orders: {
        bookee: {
          first_name: '',
          last_name: '',
          email: ''
        },
        attendee: [],
        event: {
          event_id: 0,
          department_id: 0
        }
      },
      numberTickets: [],
      dialog: false
    };
  },
  computed: {
    currentTitle: function currentTitle() {
      switch (this.step) {
        case 1:
          return 'Ticket(s)';

        case 2:
          return 'Booking Details';

        default:
          return 'Summary and Reservation';
      }
    },
    buttonTitle: function buttonTitle() {
      switch (this.step) {
        case 1:
          return 'Register';

        case 2:
          return 'Confirm Booking';

        default:
          return 'Reserve';
      }
    }
  },
  methods: {
    /*FormSubmit() {
        this.isSubmitting = true
        this.$refs.recaptcha.execute()
    },*/
    checkout: function checkout() {
      var _this = this;

      //this.resetCaptcha()
      // append recaptcha token
      //this.contact.g_recaptcha_response = token
      //this.contact.department_id = this.theEvent.department.id
      this.dialog = true;
      this.isSubmitting = true; // assign event and department id

      this.orders.event.event_id = this.theEvent.id;
      this.orders.event.department_id = this.theEvent.department_id;
      /*let filteredAttendees = this.orders.attendee.filter(function (el) {
          return el != null;
      });
      this.orders.attendee = filteredAttendees
      */

      axios.post('/api/ticket/checkout', this.orders).then(function (response) {
        if (response.data.success) {
          _this.errors = [];
          _this.isSubmitting = false;
          _this.message = response.data.message;
          _this.submitted = true;
          window.location.href = "/booking/" + response.data.item + "?is_embedded=0#order_form";
        }

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
    },
    tickets: function tickets() {},
    currentTimestamp: function currentTimestamp() {
      //return moment().toISOString()
      return moment__WEBPACK_IMPORTED_MODULE_1___default()().format('YYYY-MM-DD HH:mm:ss');
    },
    canStartSale: function canStartSale(date) {
      var currentTimestamp = this.currentTimestamp();
      return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).isSameOrBefore(currentTimestamp);
    },
    isEndOfSale: function isEndOfSale(date) {
      var currentTimestamp = this.currentTimestamp();
      return moment__WEBPACK_IMPORTED_MODULE_1___default()(date).isSameOrAfter(currentTimestamp);
    },
    ticketCount: function ticketCount() {
      return this.theEvent.tickets.length;
    },
    copyToHolder: function copyToHolder() {
      var orders = this.orders;
      orders.attendee.forEach(function (value, i) {
        orders.attendee[i].forEach(function (val, k) {
          orders.attendee[i][k].first_name = orders.bookee.first_name;
          orders.attendee[i][k].last_name = orders.bookee.last_name;
          orders.attendee[i][k].email = orders.bookee.email;
        });
      });
      this.orders.attendee = orders.attendee;
      this.$forceUpdate();
    },
    createEmptyAttendee: function createEmptyAttendee(event, ticket_id) {
      var attendeeCount = event.target.value;
      this.orders.attendee[ticket_id] = [];

      for (var i = 0; i < attendeeCount; i++) {
        var arr = [];
        arr = {
          first_name: '',
          last_name: '',
          email: ''
        };
        this.orders.attendee[ticket_id].push(arr);
      }
    },
    ticketBackButtonClicked: function ticketBackButtonClicked() {
      this.step--;
      this.scrollToElement();
    },
    ticketForwardButtonClicked: function ticketForwardButtonClicked() {
      if (this.step < 3) {
        this.step++;
      } else {
        this.checkout();
      }

      this.scrollToElement();
    },
    scrollToElement: function scrollToElement() {
      var el = this.$el.getElementsByClassName('ticket-form')[0];

      if (el) {
        el.scrollIntoView();
      }
    },
    resetTicketWindow: function resetTicketWindow() {
      window.location.reload();
    }
  },
  render: function render() {}
});

/***/ }),

/***/ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css&":
/*!*****************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css& ***!
  \*****************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, "\n.ticket-card[data-v-2c3239e5]{width:100%;}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css&":
/*!*********************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader??ref--7-1!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css& ***!
  \*********************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../../node_modules/css-loader??ref--7-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css& */ "./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css&");

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

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/TicketForm.vue?vue&type=template&id=2c3239e5&scoped=true&":
/*!**************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/components/front/events/TicketForm.vue?vue&type=template&id=2c3239e5&scoped=true& ***!
  \**************************************************************************************************************************************************************************************************************************************/
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
        { staticClass: "ticket-form", attrs: { flat: "" } },
        [
          _c(
            "v-card-title",
            { staticClass: "title font-weight-regular justify-space-between" },
            [
              _c("h1", { staticClass: "section_head text-center" }, [
                _vm._v(
                  "\n                " +
                    _vm._s(_vm.currentTitle) +
                    "\n            "
                )
              ])
            ]
          ),
          _vm._v(" "),
          _c(
            "v-window",
            {
              ref: "ticketForm",
              model: {
                value: _vm.step,
                callback: function($$v) {
                  _vm.step = $$v
                },
                expression: "step"
              }
            },
            [
              _c(
                "v-window-item",
                { ref: "ticketWindow", attrs: { value: 1 } },
                [
                  _c(
                    "v-card-text",
                    [
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
                          _vm._l(_vm.theEvent.tickets, function(ticket) {
                            return _c(
                              "v-row",
                              {
                                key: ticket.id,
                                staticClass: "ticket",
                                attrs: { property: "offers", typeof: "Offer" }
                              },
                              [
                                _c(
                                  "v-col",
                                  { attrs: { cols: "12", sm: "8", md: "8" } },
                                  [
                                    _c(
                                      "span",
                                      {
                                        staticClass: "ticket-title semibold",
                                        attrs: { property: "name" }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                    " +
                                            _vm._s(ticket.title) +
                                            "\n                                "
                                        )
                                      ]
                                    ),
                                    _vm._v(" "),
                                    _c(
                                      "p",
                                      {
                                        staticClass:
                                          "ticket-descripton mb0 text-muted",
                                        attrs: { property: "description" }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                    " +
                                            _vm._s(ticket.description) +
                                            "\n                                "
                                        )
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-col",
                                  { attrs: { cols: "12", sm: "2", md: "2" } },
                                  [
                                    _c(
                                      "div",
                                      {
                                        staticClass:
                                          "ticket-pricing float-right",
                                        staticStyle: { "margin-right": "20px" }
                                      },
                                      [
                                        _vm._v(
                                          "\n                                    FREE\n                                "
                                        )
                                      ]
                                    )
                                  ]
                                ),
                                _vm._v(" "),
                                _c(
                                  "v-col",
                                  { attrs: { cols: "12", sm: "2", md: "2" } },
                                  [
                                    ticket.is_paused
                                      ? _c("div", [
                                          _c(
                                            "span",
                                            {
                                              staticClass:
                                                "text-danger float-right"
                                            },
                                            [
                                              _vm._v(
                                                "\n                                        Ticket currently not on sale\n                                    "
                                              )
                                            ]
                                          )
                                        ])
                                      : _c("div", [
                                          ticket.quantity_available -
                                            ticket.quantity_booked ==
                                          0
                                            ? _c("div", [
                                                _c(
                                                  "span",
                                                  {
                                                    staticClass:
                                                      "text-danger float-right",
                                                    attrs: {
                                                      property: "availability",
                                                      content:
                                                        "http://schema.org/SoldOut"
                                                    }
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                                Sold out\n                                        "
                                                    )
                                                  ]
                                                )
                                              ])
                                            : !_vm.canStartSale(
                                                ticket.start_book_date
                                              )
                                            ? _c("div", [
                                                _c(
                                                  "span",
                                                  {
                                                    staticClass:
                                                      "text-danger float-right"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            Sale not started yet\n                                        "
                                                    )
                                                  ]
                                                )
                                              ])
                                            : !_vm.isEndOfSale(
                                                ticket.end_book_date
                                              )
                                            ? _c("div", [
                                                _c(
                                                  "span",
                                                  {
                                                    staticClass:
                                                      "text-danger float-right"
                                                  },
                                                  [
                                                    _vm._v(
                                                      "\n                                            Sale has ended\n                                        "
                                                    )
                                                  ]
                                                )
                                              ])
                                            : _c("div", [
                                                _c("meta", {
                                                  attrs: {
                                                    property: "availability",
                                                    content:
                                                      "http://schema.org/InStock"
                                                  }
                                                }),
                                                _vm._v(" "),
                                                _c("input", {
                                                  attrs: {
                                                    name: "tickets[]",
                                                    type: "hidden"
                                                  },
                                                  domProps: { value: ticket.id }
                                                }),
                                                _vm._v(" "),
                                                ticket.quantity_available -
                                                  ticket.quantity_booked >
                                                1
                                                  ? _c(
                                                      "select",
                                                      {
                                                        directives: [
                                                          {
                                                            name: "model",
                                                            rawName: "v-model",
                                                            value:
                                                              _vm.numberTickets[
                                                                ticket.id
                                                              ],
                                                            expression:
                                                              "numberTickets[ticket.id]"
                                                          }
                                                        ],
                                                        staticClass:
                                                          "form-control float-right",
                                                        staticStyle: {
                                                          "text-align": "center"
                                                        },
                                                        attrs: {
                                                          name:
                                                            "ticket_" +
                                                            ticket.id
                                                        },
                                                        on: {
                                                          change: [
                                                            function($event) {
                                                              var $$selectedVal = Array.prototype.filter
                                                                .call(
                                                                  $event.target
                                                                    .options,
                                                                  function(o) {
                                                                    return o.selected
                                                                  }
                                                                )
                                                                .map(function(
                                                                  o
                                                                ) {
                                                                  var val =
                                                                    "_value" in
                                                                    o
                                                                      ? o._value
                                                                      : o.value
                                                                  return val
                                                                })
                                                              _vm.$set(
                                                                _vm.numberTickets,
                                                                ticket.id,
                                                                $event.target
                                                                  .multiple
                                                                  ? $$selectedVal
                                                                  : $$selectedVal[0]
                                                              )
                                                            },
                                                            function($event) {
                                                              return _vm.createEmptyAttendee(
                                                                $event,
                                                                ticket.id
                                                              )
                                                            }
                                                          ]
                                                        }
                                                      },
                                                      _vm._l(
                                                        (ticket.min_per_person,
                                                        ticket.max_per_person),
                                                        function(i) {
                                                          return _c(
                                                            "option",
                                                            {
                                                              key: i,
                                                              domProps: {
                                                                value: i
                                                              }
                                                            },
                                                            [_vm._v(_vm._s(i))]
                                                          )
                                                        }
                                                      ),
                                                      0
                                                    )
                                                  : _c(
                                                      "select",
                                                      {
                                                        directives: [
                                                          {
                                                            name: "model",
                                                            rawName: "v-model",
                                                            value:
                                                              _vm.numberTickets[
                                                                ticket.id
                                                              ],
                                                            expression:
                                                              "numberTickets[ticket.id]"
                                                          }
                                                        ],
                                                        staticClass:
                                                          "form-control float-right",
                                                        staticStyle: {
                                                          "text-align": "center"
                                                        },
                                                        attrs: {
                                                          name:
                                                            "ticket_" +
                                                            ticket.id
                                                        },
                                                        on: {
                                                          change: [
                                                            function($event) {
                                                              var $$selectedVal = Array.prototype.filter
                                                                .call(
                                                                  $event.target
                                                                    .options,
                                                                  function(o) {
                                                                    return o.selected
                                                                  }
                                                                )
                                                                .map(function(
                                                                  o
                                                                ) {
                                                                  var val =
                                                                    "_value" in
                                                                    o
                                                                      ? o._value
                                                                      : o.value
                                                                  return val
                                                                })
                                                              _vm.$set(
                                                                _vm.numberTickets,
                                                                ticket.id,
                                                                $event.target
                                                                  .multiple
                                                                  ? $$selectedVal
                                                                  : $$selectedVal[0]
                                                              )
                                                            },
                                                            function($event) {
                                                              return _vm.createEmptyAttendee(
                                                                $event,
                                                                ticket.id
                                                              )
                                                            }
                                                          ]
                                                        }
                                                      },
                                                      [
                                                        _c(
                                                          "option",
                                                          {
                                                            key: _vm.i,
                                                            attrs: {
                                                              value: "1"
                                                            }
                                                          },
                                                          [_vm._v("1")]
                                                        )
                                                      ]
                                                    )
                                              ])
                                        ])
                                  ]
                                )
                              ],
                              1
                            )
                          }),
                          _vm._v(" "),
                          _c(
                            "v-row",
                            [
                              _c(
                                "v-col",
                                { attrs: { cols: "12", sm: "12", md: "12" } },
                                [
                                  _c("v-divider"),
                                  _vm._v(" "),
                                  _c("p", { staticClass: "text-center" }, [
                                    _vm._v(
                                      'Choose the number of tickets and click "REGISTER". On the next step you will be asked for your information.'
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("v-divider")
                                ],
                                1
                              )
                            ],
                            1
                          )
                        ],
                        2
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-window-item",
                { ref: "orderWindow", attrs: { value: 2 } },
                [
                  _c(
                    "v-card-text",
                    [
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
                                { attrs: { cols: "12", sm: "8", md: "8" } },
                                [
                                  _c("h3", [_vm._v("Your Information")]),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: {
                                      label: "First Name",
                                      rules: [
                                        _vm.rules.required,
                                        _vm.rules.maxName
                                      ],
                                      "prepend-icon": "mdi-account"
                                    },
                                    model: {
                                      value: _vm.orders.bookee.first_name,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.orders.bookee,
                                          "first_name",
                                          $$v
                                        )
                                      },
                                      expression: "orders.bookee.first_name"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: {
                                      label: "Last Name",
                                      rules: [
                                        _vm.rules.required,
                                        _vm.rules.maxName
                                      ],
                                      "prepend-icon": "mdi-account"
                                    },
                                    model: {
                                      value: _vm.orders.bookee.last_name,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.orders.bookee,
                                          "last_name",
                                          $$v
                                        )
                                      },
                                      expression: "orders.bookee.last_name"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c("v-text-field", {
                                    attrs: {
                                      label: "Email",
                                      rules: [
                                        _vm.rules.required,
                                        _vm.rules.emailValid
                                      ],
                                      "prepend-icon": "mdi-mail"
                                    },
                                    model: {
                                      value: _vm.orders.bookee.email,
                                      callback: function($$v) {
                                        _vm.$set(
                                          _vm.orders.bookee,
                                          "email",
                                          $$v
                                        )
                                      },
                                      expression: "orders.bookee.email"
                                    }
                                  }),
                                  _vm._v(" "),
                                  _c(
                                    "v-btn",
                                    {
                                      attrs: {
                                        "x-small": "",
                                        depressed: "",
                                        color: "primary"
                                      },
                                      on: { click: _vm.copyToHolder }
                                    },
                                    [
                                      _vm._v(
                                        "Copy these details to all ticket holders"
                                      )
                                    ]
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _c(
                                "v-col",
                                { attrs: { cols: "12", sm: "4", md: "4" } },
                                [
                                  _c(
                                    "v-card",
                                    { attrs: { elevation: "5" } },
                                    [
                                      _c(
                                        "v-card-title",
                                        [
                                          _c("v-icon", [
                                            _vm._v(
                                              "\n                                            mdi-cart\n                                        "
                                            )
                                          ]),
                                          _vm._v(
                                            "\n                                        Order Summary\n                                    "
                                          )
                                        ],
                                        1
                                      ),
                                      _vm._v(" "),
                                      _vm._l(_vm.theEvent.tickets, function(
                                        t,
                                        i
                                      ) {
                                        return _c(
                                          "v-card-text",
                                          { key: t.id, staticClass: "order" },
                                          [
                                            _c("div", [
                                              _vm._v(_vm._s(t.title) + " x "),
                                              _c("strong", [
                                                _vm._v(
                                                  _vm._s(
                                                    _vm.numberTickets[t.id]
                                                  )
                                                )
                                              ])
                                            ]),
                                            _vm._v(" "),
                                            _c("div", [_vm._v("FREE")]),
                                            _vm._v(" "),
                                            _c("v-divider")
                                          ],
                                          1
                                        )
                                      })
                                    ],
                                    2
                                  )
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
                              _c(
                                "v-col",
                                { attrs: { cols: "12", sm: "8", md: "8" } },
                                [
                                  _c("h3", [
                                    _vm._v("Ticket Holder Information")
                                  ])
                                ]
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm._l(_vm.theEvent.tickets, function(ticket, index) {
                            return _c(
                              "v-row",
                              { key: ticket.id, staticClass: "ticket" },
                              [
                                _c(
                                  "v-col",
                                  { attrs: { cols: "12", sm: "8", md: "8" } },
                                  _vm._l(_vm.numberTickets[ticket.id], function(
                                    n,
                                    i
                                  ) {
                                    return _c(
                                      "v-row",
                                      { key: i },
                                      [
                                        _c(
                                          "v-card",
                                          {
                                            staticClass: "mb-5 ticket-card",
                                            attrs: { raised: "", tile: "" }
                                          },
                                          [
                                            _c(
                                              "v-card-title",
                                              {
                                                staticClass:
                                                  "white--text primary"
                                              },
                                              [
                                                _vm._v(
                                                  "\n                                            " +
                                                    _vm._s(ticket.title) +
                                                    " Ticket Holder " +
                                                    _vm._s(n) +
                                                    " Details\n                                        "
                                                )
                                              ]
                                            ),
                                            _vm._v(" "),
                                            _c(
                                              "v-card-text",
                                              {
                                                attrs: {
                                                  id: "ticket-holder-details"
                                                }
                                              },
                                              [
                                                _c("v-text-field", {
                                                  ref:
                                                    "ticket-holder-detail-first-name",
                                                  refInFor: true,
                                                  attrs: {
                                                    label: "First Name",
                                                    rules: [
                                                      _vm.rules.required,
                                                      _vm.rules.maxName
                                                    ],
                                                    "prepend-icon":
                                                      "mdi-account"
                                                  },
                                                  model: {
                                                    value:
                                                      _vm.orders.attendee[
                                                        ticket.id
                                                      ][i].first_name,
                                                    callback: function($$v) {
                                                      _vm.$set(
                                                        _vm.orders.attendee[
                                                          ticket.id
                                                        ][i],
                                                        "first_name",
                                                        $$v
                                                      )
                                                    },
                                                    expression:
                                                      "orders.attendee[ticket.id][i].first_name"
                                                  }
                                                }),
                                                _vm._v(" "),
                                                _c("v-text-field", {
                                                  attrs: {
                                                    label: "Last Name",
                                                    rules: [
                                                      _vm.rules.required,
                                                      _vm.rules.maxName
                                                    ],
                                                    "prepend-icon":
                                                      "mdi-account",
                                                    id:
                                                      "ticket-holder-detail-last-name"
                                                  },
                                                  model: {
                                                    value:
                                                      _vm.orders.attendee[
                                                        ticket.id
                                                      ][i].last_name,
                                                    callback: function($$v) {
                                                      _vm.$set(
                                                        _vm.orders.attendee[
                                                          ticket.id
                                                        ][i],
                                                        "last_name",
                                                        $$v
                                                      )
                                                    },
                                                    expression:
                                                      "orders.attendee[ticket.id][i].last_name"
                                                  }
                                                }),
                                                _vm._v(" "),
                                                _c("v-text-field", {
                                                  attrs: {
                                                    label: "Email",
                                                    rules: [
                                                      _vm.rules.required,
                                                      _vm.rules.emailValid
                                                    ],
                                                    "prepend-icon": "mdi-mail",
                                                    id:
                                                      "ticket-holder-detail-email"
                                                  },
                                                  model: {
                                                    value:
                                                      _vm.orders.attendee[
                                                        ticket.id
                                                      ][i].email,
                                                    callback: function($$v) {
                                                      _vm.$set(
                                                        _vm.orders.attendee[
                                                          ticket.id
                                                        ][i],
                                                        "email",
                                                        $$v
                                                      )
                                                    },
                                                    expression:
                                                      "orders.attendee[ticket.id][i].email"
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
                                  }),
                                  1
                                )
                              ],
                              1
                            )
                          })
                        ],
                        2
                      )
                    ],
                    1
                  )
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "v-window-item",
                { ref: "confirmationWindow", attrs: { value: 3 } },
                [
                  _c(
                    "v-row",
                    [
                      _c(
                        "v-col",
                        { attrs: { cols: "12", sm: "8", md: "8" } },
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
                                "\n                            We are ready to book your reservation, please review your order and click the "
                              ),
                              _c("strong", [_vm._v("RESERVE")]),
                              _vm._v(
                                " button to proceed.\n                        "
                              )
                            ]
                          ),
                          _vm._v(" "),
                          _c(
                            "v-card",
                            {
                              staticClass: "mb-5 ticket-card",
                              attrs: { flat: "", tile: "" }
                            },
                            [
                              _c("v-card-title", [
                                _vm._v(
                                  "\n                                Bookee Details\n                            "
                                )
                              ]),
                              _vm._v(" "),
                              _c(
                                "v-card-text",
                                { attrs: { id: "ticket-holder-details" } },
                                [
                                  _c("p", { attrs: { label: "First Name" } }, [
                                    _c("strong", [_vm._v("First Name:")]),
                                    _vm._v(
                                      " " + _vm._s(_vm.orders.bookee.first_name)
                                    )
                                  ]),
                                  _vm._v(" "),
                                  _c("p", { attrs: { label: "Last Name" } }, [
                                    _c("strong", [_vm._v("Last Name:")]),
                                    _vm._v(_vm._s(_vm.orders.bookee.last_name))
                                  ]),
                                  _vm._v(" "),
                                  _c("p", { attrs: { label: "Email" } }, [
                                    _c("strong", [_vm._v("Email:")]),
                                    _vm._v(_vm._s(_vm.orders.bookee.email))
                                  ])
                                ]
                              )
                            ],
                            1
                          ),
                          _vm._v(" "),
                          _vm._l(_vm.theEvent.tickets, function(ticket, index) {
                            return _c(
                              "v-row",
                              { key: ticket.id, staticClass: "ticket" },
                              [
                                _c(
                                  "v-col",
                                  { attrs: { cols: "12", sm: "12", md: "12" } },
                                  _vm._l(_vm.numberTickets[ticket.id], function(
                                    n,
                                    i
                                  ) {
                                    return _c(
                                      "v-row",
                                      { key: i },
                                      [
                                        _c(
                                          "v-card",
                                          {
                                            staticClass: "mb-5 ticket-card",
                                            attrs: { flat: "", tile: "" }
                                          },
                                          [
                                            _c("v-card-title", [
                                              _vm._v(
                                                "\n                                            " +
                                                  _vm._s(ticket.title) +
                                                  " Ticket Holder " +
                                                  _vm._s(n) +
                                                  " Details\n                                        "
                                              )
                                            ]),
                                            _vm._v(" "),
                                            _c(
                                              "v-card-text",
                                              {
                                                staticClass: "mt-2",
                                                attrs: {
                                                  id: "ticket-holder-details"
                                                }
                                              },
                                              [
                                                _c(
                                                  "p",
                                                  {
                                                    attrs: {
                                                      label: "First Name"
                                                    }
                                                  },
                                                  [
                                                    _c("strong", [
                                                      _vm._v("First Name:")
                                                    ]),
                                                    _vm._v(
                                                      " " +
                                                        _vm._s(
                                                          _vm.orders.attendee[
                                                            ticket.id
                                                          ][i].first_name
                                                        )
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "p",
                                                  {
                                                    attrs: {
                                                      label: "Last Name"
                                                    }
                                                  },
                                                  [
                                                    _c("strong", [
                                                      _vm._v("Last Name:")
                                                    ]),
                                                    _vm._v(
                                                      _vm._s(
                                                        _vm.orders.attendee[
                                                          ticket.id
                                                        ][i].last_name
                                                      )
                                                    )
                                                  ]
                                                ),
                                                _vm._v(" "),
                                                _c(
                                                  "p",
                                                  { attrs: { label: "Email" } },
                                                  [
                                                    _c("strong", [
                                                      _vm._v("Email:")
                                                    ]),
                                                    _vm._v(
                                                      _vm._s(
                                                        _vm.orders.attendee[
                                                          ticket.id
                                                        ][i].email
                                                      )
                                                    )
                                                  ]
                                                )
                                              ]
                                            )
                                          ],
                                          1
                                        )
                                      ],
                                      1
                                    )
                                  }),
                                  1
                                )
                              ],
                              1
                            )
                          })
                        ],
                        2
                      ),
                      _vm._v(" "),
                      _c(
                        "v-col",
                        { attrs: { cols: "12", sm: "4", md: "4" } },
                        [
                          _c(
                            "v-card",
                            { attrs: { elevation: "5" } },
                            [
                              _c(
                                "v-card-title",
                                [
                                  _c("v-icon", [
                                    _vm._v(
                                      "\n                                    mdi-cart\n                                "
                                    )
                                  ]),
                                  _vm._v(
                                    "\n                                Order Summary\n                            "
                                  )
                                ],
                                1
                              ),
                              _vm._v(" "),
                              _vm._l(_vm.theEvent.tickets, function(t, i) {
                                return _c(
                                  "v-card-text",
                                  { key: t.id, staticClass: "order" },
                                  [
                                    _c("div", [
                                      _vm._v(_vm._s(t.title) + " x "),
                                      _c("strong", [
                                        _vm._v(_vm._s(_vm.numberTickets[t.id]))
                                      ])
                                    ]),
                                    _vm._v(" "),
                                    _c("div", [_vm._v("FREE")]),
                                    _vm._v(" "),
                                    _c("v-divider")
                                  ],
                                  1
                                )
                              })
                            ],
                            2
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
          _c("v-divider"),
          _vm._v(" "),
          _c(
            "v-card-actions",
            [
              _c(
                "v-btn",
                {
                  attrs: {
                    disabled: _vm.step === 1 || _vm.step === 2,
                    text: ""
                  },
                  on: { click: _vm.ticketBackButtonClicked }
                },
                [_vm._v("\n                Back\n            ")]
              ),
              _vm._v(" "),
              _c("v-spacer"),
              _vm._v(" "),
              _c(
                "v-btn",
                { attrs: { text: "" }, on: { click: _vm.resetTicketWindow } },
                [_vm._v("\n                Reset\n            ")]
              ),
              _vm._v(" "),
              _c(
                "v-btn",
                {
                  attrs: {
                    color: "primary",
                    disabled:
                      !_vm.isValid ||
                      _vm.isSubmitting ||
                      !_vm.numberTickets.length,
                    depressed: ""
                  },
                  on: { click: _vm.ticketForwardButtonClicked }
                },
                [
                  _vm._v(
                    "\n                " +
                      _vm._s(_vm.buttonTitle) +
                      "\n            "
                  )
                ]
              )
            ],
            1
          )
        ],
        1
      ),
      _vm._v(" "),
      _c(
        "v-dialog",
        {
          attrs: { "hide-overlay": "", persistent: "", width: "300" },
          model: {
            value: _vm.dialog,
            callback: function($$v) {
              _vm.dialog = $$v
            },
            expression: "dialog"
          }
        },
        [
          _c(
            "v-card",
            { attrs: { color: "primary", dark: "" } },
            [
              _c(
                "v-card-text",
                [
                  _vm._v("\n                Please standby\n                "),
                  _c("v-progress-linear", {
                    staticClass: "mb-0",
                    attrs: { indeterminate: "", color: "white" }
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
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/components/front/events/TicketForm.vue":
/*!*************************************************************!*\
  !*** ./resources/js/components/front/events/TicketForm.vue ***!
  \*************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _TicketForm_vue_vue_type_template_id_2c3239e5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./TicketForm.vue?vue&type=template&id=2c3239e5&scoped=true& */ "./resources/js/components/front/events/TicketForm.vue?vue&type=template&id=2c3239e5&scoped=true&");
/* harmony import */ var _TicketForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./TicketForm.vue?vue&type=script&lang=js& */ "./resources/js/components/front/events/TicketForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _TicketForm_vue_vue_type_style_index_0_id_2c3239e5_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css& */ "./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _TicketForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _TicketForm_vue_vue_type_template_id_2c3239e5_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _TicketForm_vue_vue_type_template_id_2c3239e5_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "2c3239e5",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/components/front/events/TicketForm.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/components/front/events/TicketForm.vue?vue&type=script&lang=js&":
/*!**************************************************************************************!*\
  !*** ./resources/js/components/front/events/TicketForm.vue?vue&type=script&lang=js& ***!
  \**************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/babel-loader/lib??ref--4-0!../../../../../node_modules/vue-loader/lib??vue-loader-options!./TicketForm.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/TicketForm.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css&":
/*!**********************************************************************************************************************!*\
  !*** ./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css& ***!
  \**********************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_style_index_0_id_2c3239e5_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/style-loader!../../../../../node_modules/css-loader??ref--7-1!../../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../../node_modules/postcss-loader/src??ref--7-2!../../../../../node_modules/vue-loader/lib??vue-loader-options!./TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js?!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/TicketForm.vue?vue&type=style&index=0&id=2c3239e5&scoped=true&lang=css&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_style_index_0_id_2c3239e5_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_style_index_0_id_2c3239e5_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_style_index_0_id_2c3239e5_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__) if(["default"].indexOf(__WEBPACK_IMPORT_KEY__) < 0) (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_style_index_0_id_2c3239e5_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_ref_7_1_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_style_index_0_id_2c3239e5_scoped_true_lang_css___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/js/components/front/events/TicketForm.vue?vue&type=template&id=2c3239e5&scoped=true&":
/*!********************************************************************************************************!*\
  !*** ./resources/js/components/front/events/TicketForm.vue?vue&type=template&id=2c3239e5&scoped=true& ***!
  \********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_template_id_2c3239e5_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../../node_modules/vue-loader/lib??vue-loader-options!./TicketForm.vue?vue&type=template&id=2c3239e5&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/components/front/events/TicketForm.vue?vue&type=template&id=2c3239e5&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_template_id_2c3239e5_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_TicketForm_vue_vue_type_template_id_2c3239e5_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);