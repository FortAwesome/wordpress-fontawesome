(window["webpackJsonp_font_awesome_admin"] = window["webpackJsonp_font_awesome_admin"] || []).push([[4],{

/***/ "./src/Alert.js":
/*!**********************!*\
  !*** ./src/Alert.js ***!
  \**********************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _Alert_module_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Alert.module.css */ "./src/Alert.module.css");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");







function getIcon(props = {}) {
  switch (props.type) {
    case 'info':
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faInfoCircle"],
        title: "info",
        fixedWidth: true
      });

    case 'warning':
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faExclamationTriangle"],
        title: "warning",
        fixedWidth: true
      });

    case 'pending':
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faSpinner"],
        title: "pending",
        spin: true,
        fixedWidth: true
      });

    case 'success':
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faThumbsUp"],
        title: "success",
        fixedWidth: true
      });

    default:
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faExclamationTriangle"],
        title: "warning",
        fixedWidth: true
      });
  }
}

function Alert(props = {}) {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_3___default()(_Alert_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['alert'], _Alert_module_css__WEBPACK_IMPORTED_MODULE_2__["default"][`alert-${props.type}`]),
    role: "alert"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _Alert_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['alert-icon']
  }, getIcon(props)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _Alert_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['alert-message']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
    className: _Alert_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['alert-title']
  }, props.title), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _Alert_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['alert-copy']
  }, props.children)));
}

Alert.propTypes = {
  title: prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.string.isRequired,
  type: prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.oneOf(['info', 'warning', 'success', 'pending']),
  children: prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.oneOfType([prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.object, prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.string, prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.arrayOf(prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.element)]).isRequired
};
/* harmony default export */ __webpack_exports__["default"] = (Alert);

/***/ }),

/***/ "./src/Alert.module.css":
/*!******************************!*\
  !*** ./src/Alert.module.css ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"alert":"_37rTwYVYjHB0pg6iso3S2_","alert-icon":"_1u7cy5-aNgYV-iJmg5Y2eP","alert-title":"_28gkoW-Ld_7ZkCsa1vOZyC","alert-message":"Acm10pRthEoE7OYjjuM1k","alert-action":"_1vcRExcmXZlbMYfI2J2o88","alert-warning":"_3yyMAjjrQSGu1mZUwVQMq8"});

/***/ }),

/***/ "./src/App.module.css":
/*!****************************!*\
  !*** ./src/App.module.css ***!
  \****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"wrapper-div":"_35TQI7cRRp15ydziejZNoy","submit-wrapper":"_3QIm6lE3_EX2f59z0q3Ede","submit-status":"_3TCHz_sQqjXivSbu8MiKvt","fail":"_1YIouJH0q7UCTBBd12BrER","fail-icon-container":"_353VvfAeyV-4WmJBZ-tkC0","explanation":"_1vEI8NfIuh1fSKAYIdxKC-","success":"_3R04ypbcTVjJT0DScCE87I","icon":"_1fPOsMtv85dkpug7YpkldL","section-title":"xPbM1D0hJUwyZDh0WkN3u","section-divider":"_1cuQ6n0S--edzcQx_whnrh","table-header":"_1bLoERoE-BGwskaCAkn6xw","more-less":"_3tsAbJj5lQ3fpUeMEqDg-p","scanner-actions":"_30U7EZBjBNVomna8JKHFEJ","scanner-runstatus":"_1XXkMTmXJKrRINZtirKC7T","faPrimary":"_1siOaPuEaRzWSp4fFZ_W2Y","conflict-detection-timer":"QIDO3zZDiUtKj7XQmNN2d","warning":"_1gtusG9lK7YrzXaZbZTTs4","sr-only":"_1rRUnYP55zlaT6KqHN-cLO","flex":"G4t9VUzKqEB2I8N67GSNt","flex-row":"_1Zhm76V3gZvaSk2u-8LU4E","flex-column":"DB4dpze5GBTvE0qtOuHn1","relative":"_3XqW__5WId-s9mUanEZmsZ","status":"U3KfFCq2Yg5XUwDHVTlA4","good":"_35z3mEQb1qzaAr4-TTAsX7","success-icon":"_2K4pJT9BAJLYON5sCxbLPN","conflict":"_1Bl4DiNxOkbomwAWx332Pz","conflict-icon":"_5VtDxQoJVBUEd_38XDCyv","warning-icon":"_3uvV5f-ofcSZUWHmud2sQF","space-left":"_1kBF31q6Fah4Pv3KJtbt9N","input-radio-custom":"_2Wb5TPvigi6MHYYjcecbxu","checked-icon":"_2qZbfXDutx3ncJTXjOwf71","input-checkbox-custom":"_7iqaMqPpiHwXZU7zXE6dw","unchecked-icon":"SQQV4UAUXLS5A0sgeAN9T","option-label-explanation":"WHTCjS863LJavtuGbeTQ1"});

/***/ }),

/***/ "./src/CdnConfigView.js":
/*!******************************!*\
  !*** ./src/CdnConfigView.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return CdnConfigView; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @fortawesome/free-regular-svg-icons */ "./node_modules/@fortawesome/free-regular-svg-icons/index.es.js");
/* harmony import */ var _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./CdnConfigView.module.css */ "./src/CdnConfigView.module.css");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! lodash/has */ "./node_modules/lodash/has.js");
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(lodash_has__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _Alert__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./Alert */ "./src/Alert.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__);















const UNSPECIFIED = '';
function CdnConfigView({
  useOption,
  handleSubmit
}) {
  const usePro = useOption('usePro');
  const technology = useOption('technology');
  const version = useOption('version');
  const v4Compat = useOption('v4Compat');
  const pseudoElements = useOption('pseudoElements');
  const pendingOptions = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.pendingOptions);
  const pendingOptionConflicts = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.pendingOptionConflicts);
  const hasChecked = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.preferenceConflictDetection.hasChecked);
  const preferenceCheckSuccess = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.preferenceConflictDetection.success);
  const preferenceCheckMessage = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.preferenceConflictDetection.message);
  const versionOptions = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => {
    const {
      releases: {
        available,
        latest_version
      }
    } = state;
    return available.reduce((acc, version) => {
      if (latest_version === version) {
        acc[version] = `${version} (latest)`;
      } else {
        acc[version] = version;
      }

      return acc;
    }, {});
  });
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();

  function handleOptionChange(change = {}, check = true) {
    const pendingTechnology = lodash_get__WEBPACK_IMPORTED_MODULE_13___default()(change, 'technology');
    const adjustedChange = pendingTechnology ? 'webfont' === pendingTechnology ? { ...change,
      pseudoElements: true
    } : { ...change,
      pseudoElements: false
    } : change;
    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_2__["addPendingOption"])(adjustedChange));
    check && dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_2__["checkPreferenceConflicts"])());
  }

  function getDetectionStatusForOption(option) {
    if (lodash_has__WEBPACK_IMPORTED_MODULE_9___default()(pendingOptions, option)) {
      if (hasChecked && !preferenceCheckSuccess) {
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_11__["default"], {
          title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Error checking preferences', 'font-awesome'),
          type: "warning"
        }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, preferenceCheckMessage));
      } else if (lodash_has__WEBPACK_IMPORTED_MODULE_9___default()(pendingOptionConflicts, option)) {
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_11__["default"], {
          title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Preference Conflict', 'font-awesome'),
          type: "warning"
        }, lodash_size__WEBPACK_IMPORTED_MODULE_10___default()(pendingOptionConflicts[option]) > 1 ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('This change might cause problems for these themes or plugins', 'font-awesome'), ": ", pendingOptionConflicts[option].join(', '), ".") : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('This change might cause problems for the theme or plugin', 'font-awesome'), ": ", pendingOptionConflicts[option][0], "."));
      } else {
        return null;
      }
    } else {
      return null;
    }
  }

  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['options-setter'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("form", {
    onSubmit: e => e.preventDefault()
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex-row'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-header']
  }, "Icons"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice-container']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choices']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "code_edit_icons_pro",
    name: "code_edit_icons",
    type: "radio",
    checked: usePro,
    onChange: () => handleOptionChange({
      usePro: true
    }),
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['input-radio-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "code_edit_icons_pro",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faDotCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, "Pro"))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "code_edit_icons_free",
    name: "code_edit_icons",
    type: "radio",
    checked: !usePro,
    onChange: () => handleOptionChange({
      usePro: false
    }),
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['input-radio-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "code_edit_icons_free",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faDotCircle"],
    size: "lg",
    fixedWidth: true,
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['checked-icon']
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faCircle"],
    size: "lg",
    fixedWidth: true,
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['unchecked-icon']
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, "Free")))), usePro && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_11__["default"], {
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Heads up! Pro requires a Font Awesome subscription', 'font-awesome'),
    type: "info"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, "And you need to add your WordPress site to the allowed domains for your CDN."), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("ul", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("li", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
    rel: "noopener noreferrer",
    target: "_blank",
    href: "https://fontawesome.com/account/cdn"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Manage my allowed domains', 'font-awesome'), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faExternalLinkAlt"],
    style: {
      marginLeft: '.5em'
    }
  }))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("li", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
    rel: "noopener noreferrer",
    target: "_blank",
    href: "https://fontawesome.com/pro"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Get Pro', 'font-awesome'), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faExternalLinkAlt"],
    style: {
      marginLeft: '.5em'
    }
  }))))), getDetectionStatusForOption('usePro'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("hr", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-divider']
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex-row'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-header']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Technology', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice-container']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choices']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "code_edit_tech_svg",
    name: "code_edit_tech",
    type: "radio",
    checked: technology === 'svg',
    onChange: () => handleOptionChange({
      technology: 'svg'
    }),
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['input-radio-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "code_edit_tech_svg",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faDotCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('SVG', 'font-awesome')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "code_edit_tech_webfont",
    name: "code_edit_tech",
    type: "radio",
    checked: technology === 'webfont',
    onChange: () => handleOptionChange({
      technology: 'webfont',
      pseudoElements: false
    }),
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['input-radio-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "code_edit_tech_webfont",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faDotCircle"],
    size: "lg",
    fixedWidth: true,
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['checked-icon']
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faCircle"],
    size: "lg",
    fixedWidth: true,
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['unchecked-icon']
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Web Font', 'font-awesome'), technology === 'webfont' && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-explanation']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('CSS Pseudo-elements are enabled by default with Web Font', 'font-awesome')))))), getDetectionStatusForOption('technology'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex-row'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-header']
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice-container'],
    style: {
      marginTop: '1em'
    }
  }, technology === 'svg' && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "code_edit_features_pseudo_elements",
    name: "code_edit_features",
    type: "checkbox",
    checked: pseudoElements,
    onChange: () => handleOptionChange({
      pseudoElements: !pseudoElements
    }),
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['input-checkbox-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "code_edit_features_pseudo_elements",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faCheckSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Enable CSS Pseudo-elements with SVG', 'font-awesome'), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-explanation']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('May cause performance issues.', 'font-awesome'), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
    rel: "noopener noreferrer",
    target: "_blank",
    style: {
      marginLeft: '.5em'
    },
    href: "https://fontawesome.com/how-to-use/on-the-web/advanced/css-pseudo-elements"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Learn more', 'font-awesome'), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faExternalLinkAlt"],
    style: {
      marginLeft: '.5em'
    }
  }))))), getDetectionStatusForOption('pseudoElements')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("hr", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-divider']
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex-row'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-header']
  }, "Version"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice-container']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choices']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['version-select'],
    name: "version",
    onChange: e => handleOptionChange({
      version: e.target.value
    }),
    value: version
  }, Object.keys(versionOptions).map((version, index) => {
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
      key: index,
      value: version
    }, version === UNSPECIFIED ? '-' : versionOptions[version]);
  }))), getDetectionStatusForOption('version'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("hr", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-divider']
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['flex-row'], _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['features'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-header']
  }, "Version 4 Compatibility"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice-container']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choices']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "code_edit_v4compat_on",
    name: "code_edit_v4compat_on",
    type: "radio",
    value: v4Compat,
    checked: v4Compat,
    onChange: () => handleOptionChange({
      v4Compat: !v4Compat
    }),
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['input-radio-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "code_edit_v4compat_on",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faDotCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('On', 'font-awesome')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-choice']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "code_edit_v4_compat_off",
    name: "code_edit_v4_compat_off",
    type: "radio",
    value: !v4Compat,
    checked: !v4Compat,
    onChange: () => handleOptionChange({
      v4Compat: !v4Compat
    }),
    className: classnames__WEBPACK_IMPORTED_MODULE_8___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['input-radio-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "code_edit_v4_compat_off",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faDotCircle"],
    size: "lg",
    fixedWidth: true,
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['checked-icon']
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faCircle"],
    size: "lg",
    fixedWidth: true,
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['unchecked-icon']
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_14__["__"])('Off', 'font-awesome'))))), getDetectionStatusForOption('v4Compat')))));
}
CdnConfigView.propTypes = {
  useOption: prop_types__WEBPACK_IMPORTED_MODULE_12___default.a.func.isRequired,
  handleOptionChange: prop_types__WEBPACK_IMPORTED_MODULE_12___default.a.func.isRequired,
  handleSubmit: prop_types__WEBPACK_IMPORTED_MODULE_12___default.a.func.isRequired
};

/***/ }),

/***/ "./src/CdnConfigView.module.css":
/*!**************************************!*\
  !*** ./src/CdnConfigView.module.css ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"release-provider-error":"_35hTTjyz9P0Vw0EI8H4hTj","warning-banner":"_1KIdXfpJmCMxitreKya227","option-header":"_3uOLK8PkrRh96SQCQ0bWM5","option-status":"_4g5U1EcL3eACQT4xHuZ73","option-choices":"_30TsFCEcQvnQMpqVdxLx05","option-choice":"_21tAvjNPmUSNjFu0gUS-iS","option-choice-container":"_1yvwypiEZwfGsgiB8WCn46","option-explanation":"_22XOo8hIgv5hY35U1IN2a8","option-label":"_1GzzC1IQO2jmwNrBXrYVF1","option-label-text":"QjW3t1iEGPOWsBHWvfjDe","option-divider":"_2fvrqahVIhLcKLYMTrxgMC","options-setter":"_3gc6BIdz9SuJWckHi01tSn","features":"_1b5zFa5CYKH2_9STlLNcOu","option-label-explanation":"_3t44TTi9PSBpf81r0j_oir","checking-option-status-indicator":"ruv8qTohXwk3F1CLS473Y"});

/***/ }),

/***/ "./src/CheckingOptionsStatusIndicator.js":
/*!***********************************************!*\
  !*** ./src/CheckingOptionsStatusIndicator.js ***!
  \***********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return CheckingOptionStatusIndicator; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./CdnConfigView.module.css */ "./src/CdnConfigView.module.css");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__);







function CheckingOptionStatusIndicator() {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['checking-option-status-indicator']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    spin: true,
    className: classnames__WEBPACK_IMPORTED_MODULE_4___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['icon']),
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faSpinner"]
  }), "\xA0", Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('checking for preference conflicts', 'font-awesome'), "...");
}

/***/ }),

/***/ "./src/ClientPreferencesView.js":
/*!**************************************!*\
  !*** ./src/ClientPreferencesView.js ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return ClientPreferencesView; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ClientPreferencesView.module.css */ "./src/ClientPreferencesView.module.css");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var lodash_find__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash/find */ "./node_modules/lodash/find.js");
/* harmony import */ var lodash_find__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash_find__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! lodash/has */ "./node_modules/lodash/has.js");
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(lodash_has__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__);









const UNSPECIFIED_INDICATOR = '-';

function formatVersionPreference(versionPreference = []) {
  return versionPreference.map(pref => `${pref[1]}${pref[0]}`).join(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["sprintf"])(
  /* translators: 1: space */
  Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('%1$sand%1$s'), ' '));
}

function ClientPreferencesView() {
  const clientPreferences = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.clientPreferences);
  const conflicts = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.preferenceConflicts);
  const hasAdditionalClients = lodash_size__WEBPACK_IMPORTED_MODULE_6___default()(clientPreferences);
  const hasConflicts = lodash_size__WEBPACK_IMPORTED_MODULE_6___default()(conflicts);
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['client-requirements']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h3", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['section-title']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Registered themes or plugins', 'font-awesome')), hasAdditionalClients ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['explanation']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Below is the list of active themes or plugins using Font Awesome that have opted-in to share information about the settings they are expecting.', 'font-awesome'), hasConflicts ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['explanation']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('The highlights show where the settings are mismatched. You might want to adjust your settings to match, or your icons may not work as expected.', 'font-awesome')) : null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("table", {
    className: classnames__WEBPACK_IMPORTED_MODULE_7___default()('widefat', 'striped')
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("thead", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['table-header']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Name', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
      [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: !!conflicts['usePro']
    })
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Icons', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
      [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: !!conflicts['technology']
    })
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Technology', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
      [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: !!conflicts['version']
    })
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Version', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
      [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: !!conflicts['v4Compat']
    })
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('V4 Compat', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
      [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: !!conflicts['pseudoElements']
    })
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('CSS Pseudo-elements', 'font-awesome')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tbody", null, Object.values(clientPreferences).map((client, index) => {
    const clientHasConflict = optionName => !!lodash_find__WEBPACK_IMPORTED_MODULE_4___default()(conflicts[optionName], c => c === client.name);

    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", {
      key: index
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, client.name), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
      className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
        [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: clientHasConflict('usePro')
      })
    }, lodash_has__WEBPACK_IMPORTED_MODULE_5___default()(client, 'usePro') ? client.usePro ? 'Pro' : 'Free' : UNSPECIFIED_INDICATOR), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
      className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
        [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: clientHasConflict('technology')
      })
    }, lodash_has__WEBPACK_IMPORTED_MODULE_5___default()(client, 'technology') ? client.technology : UNSPECIFIED_INDICATOR), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
      className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
        [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: clientHasConflict('version')
      })
    }, lodash_has__WEBPACK_IMPORTED_MODULE_5___default()(client, 'version') ? formatVersionPreference(client.version) : UNSPECIFIED_INDICATOR), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
      className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
        [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: clientHasConflict('v4Compat')
      })
    }, lodash_has__WEBPACK_IMPORTED_MODULE_5___default()(client, 'v4Compat') ? client.v4Compat ? 'true' : 'false' : UNSPECIFIED_INDICATOR), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
      className: classnames__WEBPACK_IMPORTED_MODULE_7___default()({
        [_ClientPreferencesView_module_css__WEBPACK_IMPORTED_MODULE_2__["default"].conflicted]: clientHasConflict('pseudoElements')
      })
    }, lodash_has__WEBPACK_IMPORTED_MODULE_5___default()(client, 'pseudoElements') ? client.pseudoElements ? 'true' : 'false' : UNSPECIFIED_INDICATOR));
  })))) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['explanation']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('No active themes or plugins have requested preferences for Font Awesome.', 'font-awesome')));
}

/***/ }),

/***/ "./src/ClientPreferencesView.module.css":
/*!**********************************************!*\
  !*** ./src/ClientPreferencesView.module.css ***!
  \**********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"client-requirements":"_1UrzqSniei3wNoyiV-DN21","conflicted":"_28mMOyOB6z9EDs3M0REw5G"});

/***/ }),

/***/ "./src/ConflictDetectionReporter.js":
/*!******************************************!*\
  !*** ./src/ConflictDetectionReporter.js ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _store_reducers__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./store/reducers */ "./src/store/reducers/index.js");
/* harmony import */ var _ConflictDetectionTimer__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./ConflictDetectionTimer */ "./src/ConflictDetectionTimer.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! lodash/has */ "./node_modules/lodash/has.js");
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(lodash_has__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _ErrorBoundary__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! ./ErrorBoundary */ "./src/ErrorBoundary.js");










 // NOTE: We don't have Webpack set up to handle the loading of CSS modules in
// a way that is compatible with our use of Shadow DOM. After a failed attempt
// to do so, we'll just use the standard React Style Object technique for assigning
// styles.
// See: https://reactjs.org/docs/dom-elements.html#style

const STATUS = {
  running: {
    code: 'Running',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Running', 'font-awesome')
  },
  done: {
    code: 'Done',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Done', 'font-awesome')
  },
  submitting: {
    code: 'Submitting',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Submitting', 'font-awesome')
  },
  none: {
    code: 'None',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('None', 'font-awesome')
  },
  error: {
    code: 'Error',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Error', 'font-awesome')
  },
  expired: {
    code: 'Expired',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Expired', 'font-awesome')
  },
  ready: {
    code: 'Ready',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Ready', 'font-awesome')
  },
  stopped: {
    code: 'Stopped',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Stopped', 'font-awesome')
  },
  stopping: {
    code: 'Stopping',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Stopping', 'font-awesome')
  },
  restarting: {
    code: 'Restarting',
    display: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Restarting', 'font-awesome')
  }
};
const STYLES = {
  container: {
    position: 'fixed',
    fontFamily: '"Helvetica Neue",Helvetica,Arial,sans-serif',
    right: '10px',
    bottom: '10px',
    width: '450px',
    height: 'auto',
    maxHeight: '60%',
    border: '1px solid #CDD4DB',
    borderRadius: '3px',
    boxShadow: '1px 1px 5px 0 rgba(132,142,151,.3)',
    background: '#008DED',
    zIndex: '99',
    overflowY: 'scroll',
    fontSize: '14px',
    lineHeight: '1.4em',
    color: '#fff'
  },
  header: {
    display: 'flex',
    justifyContent: 'space-between',
    alignItems: 'center',
    padding: '5px 20px',
    color: '#CAECFF'
  },
  content: {
    width: '100%',
    padding: '0 20px 10px 20px',
    boxSizing: 'border-box'
  },
  adminEyesOnly: {
    margin: '0',
    fontSize: '12px'
  },
  h1: {
    margin: '.3em 0',
    fontSize: '14px'
  },
  h2: {
    margin: '.3em 0',
    fontSize: '18px'
  },
  p: {
    margin: '.5em 0'
  },
  link: {
    color: '#fff'
  },
  tally: {
    display: 'flex',
    alignItems: 'center',
    margin: '.5em 0',
    textAlign: 'center'
  },
  count: {
    flexBasis: '1em',
    marginRight: '5px',
    fontWeight: '600',
    fontSize: '20px'
  },
  timerRow: {
    display: 'flex',
    alignItems: 'center',
    backgroundColor: '#0064B1',
    padding: '10px 20px',
    color: '#fff',
    fontWeight: '600'
  },
  button: {
    margin: '0 0 0 10px',
    border: '0',
    padding: '5px',
    backgroundColor: 'transparent',
    color: '#fff',
    opacity: '.7',
    cursor: 'pointer'
  },
  badness: {
    padding: '20px 25px',
    backgroundColor: '#FFC100',
    color: '#202529'
  }
};

function withErrorBoundary(Component) {
  return class extends _ErrorBoundary__WEBPACK_IMPORTED_MODULE_10__["default"] {
    render() {
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        style: STYLES.container
      }, !!this.state.error ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        style: STYLES.badness
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faExclamationTriangle"]
      }), Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])(' Whoops, this is embarrassing! Some unexpected error has occurred. There might be some additional diagnostic information in the JavaScript console.', 'font-awesome')) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(Component, null));
    }

  };
}

function ConflictDetectionReporter() {
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();
  const settingsPageUrl = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.settingsPageUrl);
  const troubleshootTabUrl = `${settingsPageUrl}&tab=ts`;
  const activeAdminTab = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.activeAdminTab);
  const currentlyOnPluginAdminPage = window.location.href.startsWith(settingsPageUrl);
  const currentlyOnTroubleshootTab = currentlyOnPluginAdminPage && activeAdminTab === _store_reducers__WEBPACK_IMPORTED_MODULE_5__["ADMIN_TAB_TROUBLESHOOT"];
  const userAttemptedToStopScanner = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.userAttemptedToStopScanner);
  const unregisteredClients = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.unregisteredClients);
  const unregisteredClientsBeforeDetection = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.unregisteredClientDetectionStatus.unregisteredClientsBeforeDetection);
  const recentConflictsDetected = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.unregisteredClientDetectionStatus.recentConflictsDetected);
  const expired = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => !state.showConflictDetectionReporter);
  const restarting = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => expired && state.conflictDetectionScannerStatus.isSubmitting);
  const scannerReady = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.conflictDetectionScannerStatus.hasSubmitted && state.conflictDetectionScannerStatus.success);
  const scannerIsStopping = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => userAttemptedToStopScanner && !state.conflictDetectionScannerStatus.hasSubmitted);
  const userStoppedScannerSuccessfully = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => userAttemptedToStopScanner && !scannerIsStopping && state.conflictDetectionScannerStatus.success);
  const runStatus = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => {
    const {
      isSubmitting,
      hasSubmitted,
      success
    } = state.unregisteredClientDetectionStatus;

    if (userAttemptedToStopScanner) {
      if (scannerIsStopping) {
        return STATUS.stopping;
      } else if (userStoppedScannerSuccessfully) {
        return STATUS.stopped;
      } else {
        // The user clicked to disable the scanner, and that action failed somehow.
        // Probably a fluke in the communication between the browser and the WordPress server.
        return STATUS.error;
      }
    } else if (restarting) {
      return STATUS.restarting;
    } else if (expired) {
      return STATUS.expired;
    } else if (scannerReady) {
      return STATUS.ready;
    } else if (success && 0 === lodash_size__WEBPACK_IMPORTED_MODULE_7___default()(unregisteredClients)) {
      return STATUS.none;
    } else if (success) {
      return STATUS.done;
    } else if (isSubmitting) {
      return STATUS.submitting;
    } else if (!hasSubmitted) {
      return STATUS.running;
    } else {
      return STATUS.error;
    }
  });
  const errorMessage = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.unregisteredClientDetectionStatus.message);

  function stopScanner() {
    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_2__["userAttemptToStopScanner"])());
    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_2__["setConflictDetectionScanner"])({
      enable: false
    }));
  }

  const expiredOrStoppedDiv = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
    style: STYLES.tally
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, lodash_size__WEBPACK_IMPORTED_MODULE_7___default()(unregisteredClients)), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, "\xA0", Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Results to Review', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
    style: STYLES.p
  }, currentlyOnTroubleshootTab ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Manage results or restart the scanner here on the Troubleshoot tab.', 'font-awesome') : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Manage results or restart the scanner on the Troubleshoot tab.', 'font-awesome'), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
    href: troubleshootTabUrl,
    style: STYLES.link
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Go', 'font-awesome')))));
  const stoppingOrSubmittingDiv = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    style: STYLES.status
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
    style: STYLES.h2
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faCog"],
    size: "sm",
    spin: true
  }), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, runStatus.display))));
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    style: STYLES.header
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h1", {
    style: STYLES.h1
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Font Awesome Conflict Scanner', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
    style: STYLES.adminEyesOnly
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('only admins can see this box', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    style: STYLES.content
  }, {
    None: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      style: STYLES.status
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
      style: STYLES.h2
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faGrin"],
      size: "sm"
    }), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('All clear!', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
      style: STYLES.p
    }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('No new conflicts found on this page.', 'font-awesome')))),
    Running: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      style: STYLES.status
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
      style: STYLES.h2
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faCog"],
      size: "sm",
      spin: true
    }), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Scanning', 'font-awesome'), "...")))),
    Restarting: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      style: STYLES.status
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
      style: STYLES.h2
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faCog"],
      size: "sm",
      spin: true
    }), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Restarting', 'font-awesome'), "...")))),
    Ready: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
      style: STYLES.h2
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faThumbsUp"],
      size: "sm"
    }), " ", Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Proton pack charged!', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
      style: STYLES.p
    }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Wander through the pages of your web site and this scanner will track progress.', 'font-awesome')))),
    Submitting: stoppingOrSubmittingDiv,
    Stopping: stoppingOrSubmittingDiv,
    Done: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      style: STYLES.status
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
      style: STYLES.h2
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faCheckCircle"],
      size: "sm"
    }), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Page scan complete', 'font-awesome')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
      style: STYLES.tally
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
      style: STYLES.count
    }, lodash_size__WEBPACK_IMPORTED_MODULE_7___default()(Object.keys(recentConflictsDetected).filter(k => !lodash_has__WEBPACK_IMPORTED_MODULE_8___default()(unregisteredClientsBeforeDetection, k)))), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('new conflicts found on this page', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
      style: STYLES.tally
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
      style: STYLES.count
    }, lodash_size__WEBPACK_IMPORTED_MODULE_7___default()(unregisteredClients)), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, "total found"), currentlyOnTroubleshootTab ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, "\xA0(", Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('manage conflicts here on the Troubleshoot tab', 'font-awesome'), ")") : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, "\xA0(", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
      href: troubleshootTabUrl,
      style: STYLES.link
    }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('manage', 'font-awesome')), ")"))),
    Expired: expiredOrStoppedDiv,
    Stopped: expiredOrStoppedDiv,
    Error: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
      style: STYLES.h2
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faSkull"]
    }), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Don\'t cross the streams! It would be bad.', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
      style: STYLES.p
    }, errorMessage))
  }[runStatus.code]), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    style: STYLES.timerRow
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_ConflictDetectionTimer__WEBPACK_IMPORTED_MODULE_6__["default"], {
    addDescription: true
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    style: STYLES.button,
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Stop timer', 'font-awesome'),
    onClick: () => stopScanner()
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_3__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_4__["faTimesCircle"],
    size: "lg"
  })))), {
    Expired: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Timer expired', 'font-awesome'),
    Stopped: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_9__["__"])('Timer stopped', 'font-awesome'),
    Restarting: null
  }[runStatus.code]));
}

/* harmony default export */ __webpack_exports__["default"] = (withErrorBoundary(ConflictDetectionReporter));

/***/ }),

/***/ "./src/ConflictDetectionScannerSection.js":
/*!************************************************!*\
  !*** ./src/ConflictDetectionScannerSection.js ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return ConflictDetectionScannerSection; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _ConflictDetectionTimer__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./ConflictDetectionTimer */ "./src/ConflictDetectionTimer.js");
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _mountConflictDetectionReporter__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./mountConflictDetectionReporter */ "./src/mountConflictDetectionReporter.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _createInterpolateElement__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./createInterpolateElement */ "./src/createInterpolateElement.js");










function ConflictDetectionScannerSection() {
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_2__["useDispatch"])();
  const detectConflictsUntil = Object(react_redux__WEBPACK_IMPORTED_MODULE_2__["useSelector"])(state => state.detectConflictsUntil);
  const nowMs = new Date().valueOf();
  const detectingConflicts = new Date(detectConflictsUntil * 1000) > nowMs;
  const {
    isSubmitting,
    hasSubmitted,
    message,
    success
  } = Object(react_redux__WEBPACK_IMPORTED_MODULE_2__["useSelector"])(state => state.conflictDetectionScannerStatus);
  const showConflictDetectionReporter = Object(react_redux__WEBPACK_IMPORTED_MODULE_2__["useSelector"])(state => state.showConflictDetectionReporter);
  const store = Object(react_redux__WEBPACK_IMPORTED_MODULE_2__["useStore"])();
  Object(react__WEBPACK_IMPORTED_MODULE_0__["useEffect"])(() => {
    if (showConflictDetectionReporter && !Object(_mountConflictDetectionReporter__WEBPACK_IMPORTED_MODULE_7__["isConflictDetectionReporterMounted"])()) {
      Object(_mountConflictDetectionReporter__WEBPACK_IMPORTED_MODULE_7__["mountConflictDetectionReporter"])({
        report: params => store.dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["reportDetectedConflicts"])(params)),
        store,
        now: true
      });
    }
  }, [showConflictDetectionReporter, store]);
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['section-title']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Detect Conflicts with Other Versions of Font Awesome', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['explanation']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('If you are having trouble loading Font Awesome icons on your WordPress site, it may be because other themes or plugins are loading conflicting versions of Font Awesome. You can use our conflict scanner to detect other versions of Font Awesome running on your site.', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_9__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Enable the scanner below and a box will appear in the bottom corner of your window while it runs for 10 minutes (only you and other admins can see the box). While the scanner is running, browse your site, especially the pages having trouble to catch any <noWrap>Slimers - *ahem* - conflicts</noWrap> in the scanner.', 'font-awesome'), {
    noWrap: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
      style: {
        whiteSpace: "nowrap"
      }
    })
  }))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['scanner-actions']
  }, detectingConflicts ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['faPrimary'],
    disabled: true
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Scanner running', 'font-awesome'), ": ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_ConflictDetectionTimer__WEBPACK_IMPORTED_MODULE_4__["default"], null)) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    className: "button button-primary",
    disabled: isSubmitting,
    onClick: () => dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["setConflictDetectionScanner"])({
      enable: true
    }))
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["sprintf"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Enable scanner for %d minutes', 'font-awesome'), _store_actions__WEBPACK_IMPORTED_MODULE_3__["CONFLICT_DETECTION_SCANNER_DURATION_MIN"])), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['scanner-runstatus']
  }, isSubmitting ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_5__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_6__["faSpinner"],
    spin: true
  }) : hasSubmitted ? success ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_5__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_6__["faCheck"]
  }) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_5__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_6__["faSkull"]
  }), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, message)) : null)), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("hr", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['section-divider']
  }));
}

/***/ }),

/***/ "./src/ConflictDetectionTimer.js":
/*!***************************************!*\
  !*** ./src/ConflictDetectionTimer.js ***!
  \***************************************/
/*! exports provided: timerString, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "timerString", function() { return timerString; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return ConflictDetectionTimer; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var lodash_padStart__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash/padStart */ "./node_modules/lodash/padStart.js");
/* harmony import */ var lodash_padStart__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash_padStart__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var lodash_dropWhile__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! lodash/dropWhile */ "./node_modules/lodash/dropWhile.js");
/* harmony import */ var lodash_dropWhile__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(lodash_dropWhile__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__);







const SECONDS_PER_DAY = 60 * 60 * 24;
const SECONDS_PER_HOUR = 60 * 60;
const SECONDS_PER_MINUTE = 60;
function timerString(durationSeconds) {
  const days = Math.floor(durationSeconds / SECONDS_PER_DAY);
  const hours = Math.floor((durationSeconds - days * SECONDS_PER_DAY) / SECONDS_PER_HOUR);
  const minutes = Math.floor((durationSeconds - (days * SECONDS_PER_DAY + hours * SECONDS_PER_HOUR)) / SECONDS_PER_MINUTE);
  const seconds = durationSeconds - (days * SECONDS_PER_DAY + hours * SECONDS_PER_HOUR + minutes * SECONDS_PER_MINUTE);
  return lodash_dropWhile__WEBPACK_IMPORTED_MODULE_5___default()([days, hours, minutes, seconds].reduce((acc, unit, index) => {
    if (0 === index && unit !== 0) {
      acc.push(unit.toString());
    } else {
      acc.push(lodash_padStart__WEBPACK_IMPORTED_MODULE_4___default()(unit.toString(), 2, '0'));
    }

    return acc;
  }, []), part => part.match(/^[0]+$/)).join(':');
}

function secondsRemaining(endTime) {
  const now = Math.floor(new Date() / 1000);
  const remaining = endTime - now;
  return remaining < 0 ? 0 : remaining;
}

function ConflictDetectionTimer({
  addDescription,
  children
}) {
  const detectConflictsUntil = Object(react_redux__WEBPACK_IMPORTED_MODULE_2__["useSelector"])(state => state.detectConflictsUntil);
  const [timeRemaining, setTimer] = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(secondsRemaining(detectConflictsUntil));
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_2__["useDispatch"])();
  Object(react__WEBPACK_IMPORTED_MODULE_0__["useEffect"])(() => {
    let timeoutId = null;

    if (secondsRemaining(detectConflictsUntil) > 0) {
      timeoutId = setTimeout(() => setTimer(secondsRemaining(detectConflictsUntil)), 1000);
    } else {
      setTimer(timerString(0));
      dispatch({
        type: 'CONFLICT_DETECTION_TIMER_EXPIRED'
      });
    }

    return () => timeoutId && clearTimeout(timeoutId);
  }, [detectConflictsUntil, timeRemaining, dispatch]);
  return timeRemaining <= 0 ? null : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['conflict-detection-timer']
  }, timerString(timeRemaining), !!addDescription && (timeRemaining > 60
  /* translators: 1: space */
  ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["sprintf"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('%1$sminutes left to browse your site for trouble', 'font-awesome'), ' ')
  /* translators: 1: space */
  : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["sprintf"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('%1$sseconds left to browse your site for trouble', 'font-awesome'), ' ')), children);
}
ConflictDetectionTimer.propTypes = {
  addDescription: prop_types__WEBPACK_IMPORTED_MODULE_1___default.a.bool
};

/***/ }),

/***/ "./src/ErrorBoundary.js":
/*!******************************!*\
  !*** ./src/ErrorBoundary.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ErrorFallbackView__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ErrorFallbackView */ "./src/ErrorFallbackView.js");
/* harmony import */ var _util_reportRequestError__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./util/reportRequestError */ "./src/util/reportRequestError.js");




class ErrorBoundary extends react__WEBPACK_IMPORTED_MODULE_0___default.a.Component {
  constructor(props) {
    super(props);
    this.state = {
      error: null,
      errorInfo: null
    };
  }

  componentDidCatch(error, errorInfo) {
    console.group(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_2__["ERROR_REPORT_PREAMBLE"]);
    console.log(error);
    console.log(errorInfo);
    console.groupEnd();
    this.setState({
      error,
      errorInfo
    });
  }

  render() {
    if (this.state.error) {
      //render fallback UI
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_ErrorFallbackView__WEBPACK_IMPORTED_MODULE_1__["default"], null);
    } else {
      //when there's not an error, render children untouched
      return this.props.children;
    }
  }

}

/* harmony default export */ __webpack_exports__["default"] = (ErrorBoundary);

/***/ }),

/***/ "./src/ErrorFallbackView.js":
/*!**********************************!*\
  !*** ./src/ErrorFallbackView.js ***!
  \**********************************/
/*! exports provided: fatalAlert, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "fatalAlert", function() { return fatalAlert; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ErrorFallbackView_module_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ErrorFallbackView.module.css */ "./src/ErrorFallbackView.module.css");
/* harmony import */ var _Alert__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Alert */ "./src/Alert.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);




const fatalAlert = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_2__["default"], {
  title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Whoops, this is embarrassing', 'font-awesome'),
  type: "warning"
}, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Some unexpected error has occurred. There might be some additional diagnostic information in the JavaScript console.', 'font-awesome')));

function ErrorFallbackView() {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _ErrorFallbackView_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['error-fallback']
  }, fatalAlert);
}

/* harmony default export */ __webpack_exports__["default"] = (ErrorFallbackView);

/***/ }),

/***/ "./src/ErrorFallbackView.module.css":
/*!******************************************!*\
  !*** ./src/ErrorFallbackView.module.css ***!
  \******************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"error-fallback":"_2viBy1vHsxDVJMV0gFbHNT","additional-message":"_1Rvae1cAbWT_FssxA1sa8n"});

/***/ }),

/***/ "./src/FontAwesomeAdminView.js":
/*!*************************************!*\
  !*** ./src/FontAwesomeAdminView.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return FontAwesomeAdminView; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _FontAwesomeAdminView_module_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./FontAwesomeAdminView.module.css */ "./src/FontAwesomeAdminView.module.css");
/* harmony import */ var _SettingsTab__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./SettingsTab */ "./src/SettingsTab.js");
/* harmony import */ var _TroubleshootTab__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./TroubleshootTab */ "./src/TroubleshootTab.js");
/* harmony import */ var _store_reducers__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./store/reducers */ "./src/store/reducers/index.js");
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__);









function FontAwesomeAdminView() {
  const activeAdminTab = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.activeAdminTab || _store_reducers__WEBPACK_IMPORTED_MODULE_6__["ADMIN_TAB_SETTINGS"]);
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_2___default()(_FontAwesomeAdminView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['font-awesome-admin-view'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h1", null, "Font Awesome"), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _FontAwesomeAdminView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['tab-header']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    onClick: () => dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_7__["setActiveAdminTab"])(_store_reducers__WEBPACK_IMPORTED_MODULE_6__["ADMIN_TAB_SETTINGS"])),
    disabled: activeAdminTab === _store_reducers__WEBPACK_IMPORTED_MODULE_6__["ADMIN_TAB_SETTINGS"]
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Settings', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    onClick: () => dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_7__["setActiveAdminTab"])(_store_reducers__WEBPACK_IMPORTED_MODULE_6__["ADMIN_TAB_TROUBLESHOOT"])),
    disabled: activeAdminTab === _store_reducers__WEBPACK_IMPORTED_MODULE_6__["ADMIN_TAB_TROUBLESHOOT"]
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Troubleshoot', 'font-awesome'))), {
    [_store_reducers__WEBPACK_IMPORTED_MODULE_6__["ADMIN_TAB_SETTINGS"]]: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_SettingsTab__WEBPACK_IMPORTED_MODULE_4__["default"], null),
    [_store_reducers__WEBPACK_IMPORTED_MODULE_6__["ADMIN_TAB_TROUBLESHOOT"]]: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_TroubleshootTab__WEBPACK_IMPORTED_MODULE_5__["default"], null)
  }[activeAdminTab]);
}

/***/ }),

/***/ "./src/FontAwesomeAdminView.module.css":
/*!*********************************************!*\
  !*** ./src/FontAwesomeAdminView.module.css ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"pseudo-elements-screenshot":"_3ypWg3waieJsRLcUfOC850","tab-header":"_2oI1VWRsbQAxlc_yOnO09E"});

/***/ }),

/***/ "./src/KitConfigView.js":
/*!******************************!*\
  !*** ./src/KitConfigView.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return KitConfigView; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./KitSelectView.module.css */ "./src/KitSelectView.module.css");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _Alert__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./Alert */ "./src/Alert.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! lodash/has */ "./node_modules/lodash/has.js");
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(lodash_has__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _createInterpolateElement__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./createInterpolateElement */ "./src/createInterpolateElement.js");












function KitConfigView({
  kitToken
}) {
  const kitTokenIsActive = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => lodash_get__WEBPACK_IMPORTED_MODULE_7___default()(state, 'options.kitToken') === kitToken);
  const kitTokenApiData = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => (state.kits || []).find(k => k.token === kitToken));
  const pendingOptionConflicts = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => state.pendingOptionConflicts);
  const hasChecked = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => state.preferenceConflictDetection.hasChecked);
  const preferenceCheckSuccess = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => state.preferenceConflictDetection.success);
  const technology = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => kitTokenIsActive ? state.options.technology : kitTokenApiData.technologySelected === 'svg' ? 'svg' : 'webfont');
  const usePro = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => kitTokenIsActive ? state.options.usePro : kitTokenApiData.licenseSelected === 'pro');
  const v4Compat = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => kitTokenIsActive ? state.options.v4Compat : kitTokenApiData.shimEnabled);
  const version = Object(react_redux__WEBPACK_IMPORTED_MODULE_5__["useSelector"])(state => kitTokenIsActive ? state.options.version : kitTokenApiData.version);

  function getDetectionStatusForOption(option) {
    if (hasChecked && preferenceCheckSuccess && lodash_has__WEBPACK_IMPORTED_MODULE_8___default()(pendingOptionConflicts, option)) {
      return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_6__["default"], {
        title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('Preference Conflict', 'font-awesome'),
        type: "warning"
      }, lodash_size__WEBPACK_IMPORTED_MODULE_9___default()(pendingOptionConflicts[option]) > 1 ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('This change might cause problems for these themes or plugins:', 'font-awesome'), " ", pendingOptionConflicts[option].join(', '), ".") : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('This change might cause problems for the theme or plugin:', 'font-awesome'), " ", pendingOptionConflicts[option][0], "."));
    } else {
      return null;
    }
  }

  return !kitTokenIsActive && !kitTokenApiData ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_6__["default"], {
    type: "warning",
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('Oh no! We could not find the kit data for the selected kit token.', 'font-awesome')
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('Try reloading.', 'font-awesome')) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['kit-config-view-container']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("table", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['selected-kit-settings']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tbody", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('Icons', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['value']
  }, usePro ? 'Pro' : 'Free', getDetectionStatusForOption('usePro'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('Technology', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['value']
  }, technology, getDetectionStatusForOption('technology'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('Version', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['value']
  }, version, getDetectionStatusForOption('version'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('Version 4 Compatibility', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['value']
  }, v4Compat ? 'On' : 'Off', getDetectionStatusForOption('v4Compat'))))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_3__["default"]['tip-text']
  }, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_11__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_10__["__"])('Make changes on <a>fontawesome.com/kits <externalLinkIcon/></a>', 'font-awesome'), {
    // eslint-disable-next-line jsx-a11y/anchor-has-content
    a: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
      target: "_blank",
      rel: "noopener noreferrer",
      href: "https://fontawesome.com/kits"
    }),
    externalLinkIcon: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_1__["FontAwesomeIcon"], {
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_2__["faExternalLinkAlt"],
      style: {
        marginLeft: '.5em'
      }
    })
  })));
}
KitConfigView.propTypes = {
  kitToken: prop_types__WEBPACK_IMPORTED_MODULE_4___default.a.string.isRequired
};

/***/ }),

/***/ "./src/KitSelectView.js":
/*!******************************!*\
  !*** ./src/KitSelectView.js ***!
  \******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return KitSelectView; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _Alert__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Alert */ "./src/Alert.js");
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @fortawesome/free-regular-svg-icons */ "./node_modules/@fortawesome/free-regular-svg-icons/index.es.js");
/* harmony import */ var _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./KitSelectView.module.css */ "./src/KitSelectView.module.css");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_9___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_9__);
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! prop-types */ "./node_modules/prop-types/index.js");
/* harmony import */ var prop_types__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(prop_types__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__);













function KitSelectView({
  useOption,
  masterSubmitButtonShowing,
  setMasterSubmitButtonShowing
}) {
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();
  const kitTokenActive = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.options.kitToken);
  const kitToken = useOption('kitToken');
  const [pendingApiToken, setPendingApiToken] = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(null);
  const [showingRemoveApiTokenAlert, setShowRemoveApiTokenAlert] = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(false);
  const [showApiTokenInputForUpdate, setShowApiTokenInputForUpdate] = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(false);
  const apiToken = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => {
    if (null !== pendingApiToken) return pendingApiToken;
    return state.options.apiToken;
  });
  const kits = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.kits) || [];
  const hasSubmitted = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.optionsFormState.hasSubmitted);
  const submitSuccess = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.optionsFormState.success);
  const submitMessage = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.optionsFormState.message);
  const isSubmitting = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.optionsFormState.isSubmitting);

  function removeApiToken() {
    if (!!kitTokenActive) {
      setShowRemoveApiTokenAlert(true);
    } else {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["updateApiToken"])({
        apiToken: false
      }));
    }
  }
  /**
   * When selecting a kit, we go through each of its configuration options
   * and add them as pending options. We don't set those options in this system:
   * they come as read-only from the Font Awesome API. But setting them as pending
   * here allows them to processed by the preference checker to notify the user
   * in the UI if selecting this kit would result in any known preference conflicts
   * with registered clients.
   */


  function handleKitChange({
    kitToken
  }) {
    if ('' === kitToken) {
      // You can't select a non-kit option. The empty option only
      // appears in the selection dropdown as a placeholder before a kit is
      // selected
      return;
    }

    const selectedKit = (kits || []).find(k => k.token === kitToken);

    if (!selectedKit) {
      throw new Error(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["sprintf"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('When selecting to use kit %s, somehow the information we needed was missing. Try reloading the page.'), kitToken));
    }

    if (kitTokenActive === kitToken) {
      // We're just resetting back to the state we were in
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["resetPendingOptions"])());
    } else {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["addPendingOption"])({
        kitToken,
        technology: 'svg' === selectedKit.technologySelected ? 'svg' : 'webfont',
        usePro: 'pro' === selectedKit.licenseSelected,
        v4Compat: selectedKit.shimEnabled,
        version: selectedKit.version,
        // At the time this is being implemented, kits don't yet support
        // toggling pseudoElement support for SVG, but it's implicitly supported for webfont.
        pseudoElements: 'svg' !== selectedKit.technologySelected
      }));
    }

    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["checkPreferenceConflicts"])());
  }

  const kitsQueryStatus = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.kitsQueryStatus);
  /**
   * This seems like a lot of effort just to keep the focus on the API Token input
   * field during data entry, but it's because the component is being re-rendered
   * on each change, and thus a new input DOM element is being created on each change.
   * So the input element doesn't so much "lose focus" as is it just replaced by a
   * different DOM element.
   * So it's more like we have to re-focus on that new DOM element each time it changes.
   * This would happen keystroke by keystroke if the user types in an API Token.
   * Or if content is pasted into the field all at once, we'd like the focus to remain there
   * in the input field until the user intentionally blurs by clicking the submit
   * button, or pressing the tab key, for example.
   */

  const apiTokenInputRef = /*#__PURE__*/Object(react__WEBPACK_IMPORTED_MODULE_0__["createRef"])();
  const [apiTokenInputHasFocus, setApiTokenInputHasFocus] = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(false);
  Object(react__WEBPACK_IMPORTED_MODULE_0__["useEffect"])(() => {
    if (!!apiTokenInputRef.current && apiTokenInputHasFocus) {
      apiTokenInputRef.current.focus();
    }
  });
  const hasSavedApiToken = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => !!state.options.apiToken);

  function cancelApiTokenUpdate() {
    setShowApiTokenInputForUpdate(false);
    setMasterSubmitButtonShowing(true);
    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["resetOptionsFormState"])());
  }

  function ApiTokenInput() {
    Object(react__WEBPACK_IMPORTED_MODULE_0__["useEffect"])(() => {
      if (submitSuccess && showApiTokenInputForUpdate) {
        setShowApiTokenInputForUpdate(false);
        setMasterSubmitButtonShowing(true);
      }
    });
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['field-apitoken'], {
        [_KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['api-token-update']]: showApiTokenInputForUpdate
      })
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
      htmlFor: "api_token"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_6__["faQuestionCircle"],
      size: "lg"
    }), Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('API Token', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
      id: "api_token",
      name: "api_token",
      type: "text",
      ref: apiTokenInputRef,
      value: pendingApiToken || '',
      size: "20",
      onChange: e => {
        setApiTokenInputHasFocus(true);
        setPendingApiToken(e.target.value);
      }
    }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Grab your secure and unique API token from your Font Awesome account page and enter it here so we can securely fetch your kits.', 'font-awesome'), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
      target: "_blank",
      rel: "noopener noreferrer",
      href: "https://fontawesome.com/account#api-tokens"
    }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Get your API token on fontawesome.com', 'font-awesome'), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faExternalLinkAlt"],
      style: {
        marginLeft: '.5em'
      }
    }))))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: "submit"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
      type: "submit",
      name: "submit",
      id: "submit",
      className: "button button-primary",
      value: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Save API Token', 'font-awesome'),
      disabled: !pendingApiToken,
      onMouseDown: () => {
        dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["updateApiToken"])({
          apiToken: pendingApiToken,
          runQueryKits: true
        }));
        setPendingApiToken(null);
      }
    }), hasSubmitted && !submitSuccess && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['fail'])
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['fail-icon-container'])
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faSkull"]
    })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['explanation']
    }, submitMessage)), isSubmitting && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
      className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['submitting'])
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faSpinner"],
      spin: true
    })), showApiTokenInputForUpdate && !isSubmitting && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
      onClick: () => cancelApiTokenUpdate(),
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['button-dismissable']
    }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Nevermind', 'font-awesome'))));
  }

  function ApiTokenControl() {
    function switchToApiTokenUpdate() {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["resetOptionsFormState"])());
      setShowApiTokenInputForUpdate(true);
      setMasterSubmitButtonShowing(false);
      setShowRemoveApiTokenAlert(false);
    }

    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['api-token-control-wrapper']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['api-token-control'], {
        [_KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['api-token-update']]: showApiTokenInputForUpdate
      })
    }, showApiTokenInputForUpdate ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(ApiTokenInput, null) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['token-saved']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_6__["faCheckCircle"],
      size: "lg"
    })), Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('API Token Saved', 'font-awesome')), !!apiToken && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['button-group']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
      onClick: () => switchToApiTokenUpdate(),
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['refresh'],
      type: "button"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faSync"],
      title: "update",
      alt: "update"
    }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Update token', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
      onClick: () => removeApiToken(),
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['remove'],
      type: "button"
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faTrashAlt"],
      title: "remove",
      alt: "remove"
    }))))), showingRemoveApiTokenAlert && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['api-token-control-alert-wrapper']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_2__["default"], {
      title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Whoa, whoa, whoa!', 'font-awesome'),
      type: "warning"
    }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('You can\'t remove your API token when "Use a Kit" is active. Switch to "Use CDN" first.', 'font-awesome'))));
  }

  const STATUS = {
    querying: 'querying',
    showingOnlyActiveKit: 'showingOnlyActiveKit',
    noKitsFoundAfterQuery: 'noKitsFoundAfterQuery',
    networkError: 'networkError',
    kitSelection: 'kitSelection',
    noApiToken: 'noApiToken',
    apiTokenReadyNoKitsYet: 'apiTokenReadyNoKitsYet'
  };

  function KitSelector() {
    const status = apiToken ? kitsQueryStatus.isSubmitting ? STATUS.querying : kitsQueryStatus.hasSubmitted ? kitsQueryStatus.success ? lodash_size__WEBPACK_IMPORTED_MODULE_11___default()(kits) > 0 ? STATUS.kitSelection : STATUS.noKitsFoundAfterQuery : STATUS.networkError : kitTokenActive ? STATUS.showingOnlyActiveKit : STATUS.apiTokenReadyNoKitsYet : STATUS.noApiToken;
    const kitRefreshButton = /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
      onClick: () => dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_3__["queryKits"])()),
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['refresh']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faRedo"],
      title: "refresh",
      alt: "refresh"
    }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, 0 === lodash_size__WEBPACK_IMPORTED_MODULE_11___default()(kits) ? Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Get latest kits data', 'font-awesome') : Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Refresh kits data', 'font-awesome')));
    const activeKitNotice = kitTokenActive ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['wrap-active-kit']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
      className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['active-kit'], _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['set'])
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_6__["faCheckCircle"],
      size: "lg"
    }), Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["sprintf"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('%s Kit is Currently Active'), kitTokenActive))) : null;
    return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['kit-selector-container']
    }, activeKitNotice, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['wrap-selectkit']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h3", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['title-selectkit']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
      className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
      icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_6__["faQuestionCircle"],
      size: "lg"
    }), Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Pick a Kit to Use or Check Settings', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
      className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['selectkit']
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Refresh your kits data to get the latest kit settings, then select the kit you would like to use. Remember to save when you\'re ready to use it.', 'font-awesome')), {
      noApiToken: 'noApiToken',
      apiTokenReadyNoKitsYet: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, activeKitNotice, " ", kitRefreshButton),
      querying: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Loading your kits...', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
        className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['submitting'])
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
        className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faSpinner"],
        spin: true
      }))),
      networkError: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['fail'])
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: classnames__WEBPACK_IMPORTED_MODULE_9___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['fail-icon-container'])
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
        className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['icon'],
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faSkull"]
      })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: _App_module_css__WEBPACK_IMPORTED_MODULE_8__["default"]['explanation']
      }, kitsQueryStatus.message)),
      noKitsFoundAfterQuery: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_2__["default"], {
        title: "Zoinks! Looks like you don't have any kits set up yet.",
        type: "info"
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Head over to Font Awesome to create one, then come back here and refresh your kits.', 'font-awesome'), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
        rel: "noopener noreferrer",
        target: "_blank",
        href: "https://fontawesome.com/kits"
      }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Create a kit on Font Awesome', 'font-awesome'), " ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_4__["FontAwesomeIcon"], {
        icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_5__["faExternalLinkAlt"]
      })))), kitRefreshButton),
      kitSelection: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
        className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['field-kitselect']
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("select", {
        className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['kit-select'],
        id: "kits",
        name: "kit",
        onChange: e => handleKitChange({
          kitToken: e.target.value
        }),
        disabled: !masterSubmitButtonShowing,
        value: kitToken || ''
      }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
        key: "empty",
        value: ""
      }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Select a kit', 'font-awesome')), kits.map((kit, index) => {
        return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("option", {
          key: index,
          value: kit.token
        }, `${kit.name} (${kit.token})`);
      })), kitRefreshButton)),
      showingOnlyActiveKit: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, kitRefreshButton)
    }[status])));
  }

  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _KitSelectView_module_css__WEBPACK_IMPORTED_MODULE_7__["default"]['kit-tab-content']
  }, hasSavedApiToken ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(ApiTokenControl, null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(KitSelector, null)) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(ApiTokenInput, null)));
}
KitSelectView.propTypes = {
  useOption: prop_types__WEBPACK_IMPORTED_MODULE_10___default.a.func.isRequired,
  handleOptionChange: prop_types__WEBPACK_IMPORTED_MODULE_10___default.a.func.isRequired,
  masterSubmitButtonShowing: prop_types__WEBPACK_IMPORTED_MODULE_10___default.a.bool.isRequired,
  setMasterSubmitButtonShowing: prop_types__WEBPACK_IMPORTED_MODULE_10___default.a.func.isRequired
};

/***/ }),

/***/ "./src/KitSelectView.module.css":
/*!**************************************!*\
  !*** ./src/KitSelectView.module.css ***!
  \**************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"kit-tab-content":"_28QZlt6_eMguVsewh_If7O","field-apitoken":"_3XAGdWqu8n0zhwMGk1BsnX","api-token-control-wrapper":"_2c5uegkd0X00sTtcB0xdoQ","api-token-control":"_1L1Kf3TFjZx_mks1O5SkVi","api-token-update":"_1-gBzGYUEwLyLHeLMBEMwj","token-saved":"_3MXv0QQ6W7n1Hts4HW4Csg","remove":"_1jhyXzEBwJqxL9zqlpoIww","button-group":"_Y5_Omf22TYoy0ZWNdEuw","button-dismissable":"_2jBDyGpkbYxNCwBJ_k0Nm3","wrap-active-kit":"_1wiueJOFX59ECYNHSLnLrc","active-kit":"Pm89a4v_XS3zo4gCDRvsD","set":"_1jHYygm8YcEecXKcXZ3yun","none":"KyAPwjv_5OEa2qrgyR3qP","wrap-selectkit":"_36VNlV86_Vo6VLLPo4RpP-","title-selectkit":"_1wgl2UkEikiWF7W6NhVBbY","selectkit":"_3__EkzsnWNxeT5MlF991by","refresh":"_25c2vRu37RP7A4GuforSEY","kit-selector-container":"_2hFKmV2Ft2SiM9s0Pnbidc","kit-select":"_2c79ff1FL3CUQBI7c2dLMf","kit-config-view-container":"ANzaBl0vWw8KMvZagq9mw","selected-kit-settings":"_3osTFnQq4hThM_pvlpWsMh","label":"_1cHOmK1BKpg_0eZXqe8qz-","value":"_3_hn6iqIVDWU8TQG87Tepw","tip-text":"_2gkL85I-CozK-9p5_5bl3Q"});

/***/ }),

/***/ "./src/ManageFontAwesomeVersionsSection.js":
/*!*************************************************!*\
  !*** ./src/ManageFontAwesomeVersionsSection.js ***!
  \*************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return ManageFontAwesomeVersionsSection; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ManageFontAwesomeVersionsSection_module_css__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ManageFontAwesomeVersionsSection.module.css */ "./src/ManageFontAwesomeVersionsSection.module.css");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var _ClientPreferencesView__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./ClientPreferencesView */ "./src/ClientPreferencesView.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _createInterpolateElement__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./createInterpolateElement */ "./src/createInterpolateElement.js");







function ManageFontAwesomeVersionsSection() {
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_4___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['explanation'], _ManageFontAwesomeVersionsSection_module_css__WEBPACK_IMPORTED_MODULE_1__["default"]['font-awesome-versions-section'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h2", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_2__["default"]['section-title']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__["__"])('Versions of Font Awesome Active on Your Site', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_6__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_5__["__"])('<b>Registered plugins and themes</b> have opted to share information about the Font Awesome settings they are expecting, and are therefore easier to fix. For the <b>unregistered plugins and themes</b>, which are more unpredictable, we have provided options for you to block their Font Awesome source from loading and causing issues.', 'font-awesome'), {
    b: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("b", null)
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_ClientPreferencesView__WEBPACK_IMPORTED_MODULE_3__["default"], null));
}

/***/ }),

/***/ "./src/ManageFontAwesomeVersionsSection.module.css":
/*!*********************************************************!*\
  !*** ./src/ManageFontAwesomeVersionsSection.module.css ***!
  \*********************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({});

/***/ }),

/***/ "./src/SettingsTab.js":
/*!****************************!*\
  !*** ./src/SettingsTab.js ***!
  \****************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return SettingsTab; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _CdnConfigView__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./CdnConfigView */ "./src/CdnConfigView.js");
/* harmony import */ var _KitSelectView__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./KitSelectView */ "./src/KitSelectView.js");
/* harmony import */ var _KitConfigView__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./KitConfigView */ "./src/KitConfigView.js");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! ./CdnConfigView.module.css */ "./src/CdnConfigView.module.css");
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @fortawesome/free-regular-svg-icons */ "./node_modules/@fortawesome/free-regular-svg-icons/index.es.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var _SettingsTab_module_css__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! ./SettingsTab.module.css */ "./src/SettingsTab.module.css");
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! lodash/has */ "./node_modules/lodash/has.js");
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(lodash_has__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _CheckingOptionsStatusIndicator__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! ./CheckingOptionsStatusIndicator */ "./src/CheckingOptionsStatusIndicator.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_15__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__);

















function SettingsTab() {
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();
  const alreadyUsingKit = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => !!state.options.kitToken);
  const [useKit, setUseKit] = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(alreadyUsingKit);
  const isChecking = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.preferenceConflictDetection.isChecking);
  const hasSubmitted = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.optionsFormState.hasSubmitted);
  const submitSuccess = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.optionsFormState.success);
  const submitMessage = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.optionsFormState.message);
  const isSubmitting = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.optionsFormState.isSubmitting);
  const pendingOptions = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.pendingOptions);
  const apiToken = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.options.apiToken);
  const [masterSubmitButtonShowing, setMasterSubmitButtonShowing] = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(true);

  function useOption(option) {
    return Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => lodash_has__WEBPACK_IMPORTED_MODULE_12___default()(state.pendingOptions, option) ? state.pendingOptions[option] : state.options[option]);
  }

  function handleSubmit(e) {
    if (!!e && 'function' == typeof e.preventDefault) {
      e.preventDefault();
    }

    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_13__["submitPendingOptions"])());
  } // The kitToken that may be a pendingOption


  const kitToken = useOption('kitToken'); // The one that's actually saved in the database already

  const activeKitToken = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.options.kitToken);

  function handleOptionChange(change = {}) {
    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_13__["addPendingOption"])(change));
  }
  /**
   * In this case, we need to not only toggle the component's local
   * state, but also get rid of the kitToken and any pending options
   * that a kit selection might have put onto the form.
   */


  function handleSwitchAwayFromKitConfig() {
    setUseKit(false);
    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_13__["chooseAwayFromKitConfig"])({
      activeKitToken
    }));
  }

  function handleSwitchToKitConfig() {
    setUseKit(true);
    setMasterSubmitButtonShowing(true);
    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_13__["chooseIntoKitConfig"])());
  }

  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['wrapper-div']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h3", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('How are you using Font Awesome?', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _SettingsTab_module_css__WEBPACK_IMPORTED_MODULE_11__["default"]['select-config-container']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "select_use_kits",
    name: "select_use_kits",
    type: "radio",
    value: useKit,
    checked: useKit,
    onChange: () => handleSwitchToKitConfig(),
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['input-radio-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "select_use_kits",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faDotCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('Use A Kit', 'font-awesome')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "select_use_cdn",
    name: "select_use_cdn",
    type: "radio",
    value: !useKit,
    checked: !useKit,
    onChange: () => handleSwitchAwayFromKitConfig(),
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['input-radio-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "select_use_cdn",
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faDotCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faCircle"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _CdnConfigView_module_css__WEBPACK_IMPORTED_MODULE_6__["default"]['option-label-text']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('Use CDN', 'font-awesome'))))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, useKit ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_KitSelectView__WEBPACK_IMPORTED_MODULE_3__["default"], {
    useOption: useOption,
    handleOptionChange: handleOptionChange,
    handleSubmit: handleSubmit,
    masterSubmitButtonShowing: masterSubmitButtonShowing,
    setMasterSubmitButtonShowing: setMasterSubmitButtonShowing
  }), !!kitToken && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_KitConfigView__WEBPACK_IMPORTED_MODULE_4__["default"], {
    kitToken: kitToken
  })) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_CdnConfigView__WEBPACK_IMPORTED_MODULE_2__["default"], {
    useOption: useOption,
    handleOptionChange: handleOptionChange,
    handleSubmit: handleSubmit
  }))), (!useKit || apiToken && masterSubmitButtonShowing) && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-wrapper'], ['submit'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    type: "submit",
    name: "submit",
    id: "submit",
    className: "button button-primary",
    value: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('Save Changes', 'font-awesome'),
    disabled: lodash_size__WEBPACK_IMPORTED_MODULE_15___default()(pendingOptions) === 0,
    onClick: handleSubmit
  }), hasSubmitted ? submitSuccess ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['success'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['icon'],
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faCheck"]
  })) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['fail'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['fail-icon-container'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['icon'],
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faSkull"]
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['explanation']
  }, submitMessage)) : null, isSubmitting ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submitting'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['icon'],
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faSpinner"],
    spin: true
  })) : isChecking ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_CheckingOptionsStatusIndicator__WEBPACK_IMPORTED_MODULE_14__["default"], null) : lodash_size__WEBPACK_IMPORTED_MODULE_15___default()(pendingOptions) > 0 ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-status']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('you have pending changes', 'font-awesome')) : null));
}

/***/ }),

/***/ "./src/SettingsTab.module.css":
/*!************************************!*\
  !*** ./src/SettingsTab.module.css ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"select-config-container":"_1bukux-P5kbXG3NlffwKJP"});

/***/ }),

/***/ "./src/TroubleshootTab.js":
/*!********************************!*\
  !*** ./src/TroubleshootTab.js ***!
  \********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return TroubleshootTab; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _ManageFontAwesomeVersionsSection__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./ManageFontAwesomeVersionsSection */ "./src/ManageFontAwesomeVersionsSection.js");
/* harmony import */ var _UnregisteredClientsView__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./UnregisteredClientsView */ "./src/UnregisteredClientsView.js");
/* harmony import */ var _V3DeprecationWarning__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./V3DeprecationWarning */ "./src/V3DeprecationWarning.js");
/* harmony import */ var _ConflictDetectionScannerSection__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./ConflictDetectionScannerSection */ "./src/ConflictDetectionScannerSection.js");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__);













function TroubleshootTab() {
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_7__["useDispatch"])();
  const hasV3DeprecationWarning = Object(react_redux__WEBPACK_IMPORTED_MODULE_7__["useSelector"])(state => !!state.v3DeprecationWarning);
  const unregisteredClients = Object(react_redux__WEBPACK_IMPORTED_MODULE_7__["useSelector"])(state => state.unregisteredClients);
  const blocklistUpdateStatus = Object(react_redux__WEBPACK_IMPORTED_MODULE_7__["useSelector"])(state => state.blocklistUpdateStatus);
  const unregisteredClientsDeletionStatus = Object(react_redux__WEBPACK_IMPORTED_MODULE_7__["useSelector"])(state => state.unregisteredClientsDeletionStatus);
  const showSubmitButton = lodash_size__WEBPACK_IMPORTED_MODULE_11___default()(unregisteredClients) > 0;
  const hasPendingChanges = null !== blocklistUpdateStatus.pending || lodash_size__WEBPACK_IMPORTED_MODULE_11___default()(unregisteredClientsDeletionStatus.pending) > 0;
  const hasSubmitted = unregisteredClientsDeletionStatus.hasSubmitted || blocklistUpdateStatus.hasSubmitted;
  const isSubmitting = unregisteredClientsDeletionStatus.isSubmitting || blocklistUpdateStatus.isSubmitting;
  const submitSuccess = (unregisteredClientsDeletionStatus.hasSubmitted || blocklistUpdateStatus.hasSubmitted) && (unregisteredClientsDeletionStatus.success || !unregisteredClientsDeletionStatus.hasSubmitted) && (blocklistUpdateStatus.success || !blocklistUpdateStatus.hasSubmitted);

  function handleSubmitClick(e) {
    e.preventDefault();

    if (blocklistUpdateStatus.pending) {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_8__["submitPendingBlocklist"])());
    } else {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_8__["resetPendingBlocklistSubmissionStatus"])());
    }

    if (lodash_size__WEBPACK_IMPORTED_MODULE_11___default()(unregisteredClientsDeletionStatus.pending) > 0) {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_8__["submitPendingUnregisteredClientDeletions"])());
    } else {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_8__["resetUnregisteredClientsDeletionStatus"])());
    }
  }

  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['wrapper-div']
  }, hasV3DeprecationWarning && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_V3DeprecationWarning__WEBPACK_IMPORTED_MODULE_3__["default"], null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_ConflictDetectionScannerSection__WEBPACK_IMPORTED_MODULE_4__["default"], null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_ManageFontAwesomeVersionsSection__WEBPACK_IMPORTED_MODULE_1__["default"], null), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_UnregisteredClientsView__WEBPACK_IMPORTED_MODULE_2__["default"], null)), showSubmitButton && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-wrapper'], ['submit'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    type: "submit",
    name: "submit",
    id: "submit",
    className: "button button-primary",
    value: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('Save Changes', 'font-awesome'),
    disabled: !hasPendingChanges,
    onClick: handleSubmitClick
  }), hasSubmitted ? submitSuccess ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['success'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_6__["FontAwesomeIcon"], {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['icon'],
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faCheck"]
  })) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['fail'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['fail-icon-container'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_6__["FontAwesomeIcon"], {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['icon'],
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faSkull"]
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['explanation']
  }, !!blocklistUpdateStatus.message && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, " ", blocklistUpdateStatus.message, " "), !!unregisteredClientsDeletionStatus.message && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, " ", unregisteredClientsDeletionStatus.message, " "))) : null, isSubmitting ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: classnames__WEBPACK_IMPORTED_MODULE_10___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-status'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submitting'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_6__["FontAwesomeIcon"], {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['icon'],
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faSpinner"],
    spin: true
  })) : hasPendingChanges ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submit-status']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_12__["__"])('you have pending changes', 'font-awesome')) : null));
}

/***/ }),

/***/ "./src/UnregisteredClientsView.js":
/*!****************************************!*\
  !*** ./src/UnregisteredClientsView.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return UnregisteredClientsView; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _store_reducers__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./store/reducers */ "./src/store/reducers/index.js");
/* harmony import */ var _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./UnregisteredClientsView.module.css */ "./src/UnregisteredClientsView.module.css");
/* harmony import */ var _App_module_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./App.module.css */ "./src/App.module.css");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! @fortawesome/free-regular-svg-icons */ "./node_modules/@fortawesome/free-regular-svg-icons/index.es.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_10__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_10___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_10__);
/* harmony import */ var lodash_truncate__WEBPACK_IMPORTED_MODULE_11__ = __webpack_require__(/*! lodash/truncate */ "./node_modules/lodash/truncate.js");
/* harmony import */ var lodash_truncate__WEBPACK_IMPORTED_MODULE_11___default = /*#__PURE__*/__webpack_require__.n(lodash_truncate__WEBPACK_IMPORTED_MODULE_11__);
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_12__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_12___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_12__);
/* harmony import */ var lodash_isEqual__WEBPACK_IMPORTED_MODULE_13__ = __webpack_require__(/*! lodash/isEqual */ "./node_modules/lodash/isEqual.js");
/* harmony import */ var lodash_isEqual__WEBPACK_IMPORTED_MODULE_13___default = /*#__PURE__*/__webpack_require__.n(lodash_isEqual__WEBPACK_IMPORTED_MODULE_13__);
/* harmony import */ var lodash_sortedUniq__WEBPACK_IMPORTED_MODULE_14__ = __webpack_require__(/*! lodash/sortedUniq */ "./node_modules/lodash/sortedUniq.js");
/* harmony import */ var lodash_sortedUniq__WEBPACK_IMPORTED_MODULE_14___default = /*#__PURE__*/__webpack_require__.n(lodash_sortedUniq__WEBPACK_IMPORTED_MODULE_14__);
/* harmony import */ var lodash_difference__WEBPACK_IMPORTED_MODULE_15__ = __webpack_require__(/*! lodash/difference */ "./node_modules/lodash/difference.js");
/* harmony import */ var lodash_difference__WEBPACK_IMPORTED_MODULE_15___default = /*#__PURE__*/__webpack_require__.n(lodash_difference__WEBPACK_IMPORTED_MODULE_15__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_16___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__);
/* harmony import */ var _createInterpolateElement__WEBPACK_IMPORTED_MODULE_17__ = __webpack_require__(/*! ./createInterpolateElement */ "./src/createInterpolateElement.js");



















function excerpt(content) {
  if (!!content) {
    return lodash_truncate__WEBPACK_IMPORTED_MODULE_11___default()(content, {
      length: 100
    });
  } else {
    return null;
  }
}

function UnregisteredClientsView() {
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();
  const unregisteredClients = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.unregisteredClients);
  const savedBlocklist = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => Object(_store_reducers__WEBPACK_IMPORTED_MODULE_3__["blocklistSelector"])(state));
  const blocklist = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => {
    if (null !== state.blocklistUpdateStatus.pending) {
      return state.blocklistUpdateStatus.pending;
    } else {
      return savedBlocklist;
    }
  });
  const deleteList = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.unregisteredClientsDeletionStatus.pending);
  const detectedUnregisteredClients = lodash_size__WEBPACK_IMPORTED_MODULE_12___default()(Object.keys(unregisteredClients)) > 0;
  const allDetectedConflictsSelectedForBlocking = lodash_isEqual__WEBPACK_IMPORTED_MODULE_13___default()(Object.keys(unregisteredClients).sort(), [...(blocklist || [])].sort());
  const allDetectedConflictsSelectedForRemoval = lodash_isEqual__WEBPACK_IMPORTED_MODULE_13___default()(Object.keys(unregisteredClients).sort(), [...(deleteList || [])].sort());
  const allDetectedConflicts = Object.keys(unregisteredClients);

  function isCheckedForBlocking(md5) {
    return !!blocklist.find(x => x === md5);
  }

  function isCheckedForRemoval(md5) {
    return !!deleteList.find(x => x === md5);
  }

  function changeCheckForRemoval(md5, allDetectedConflicts) {
    const newDeleteList = 'all' === md5 ? allDetectedConflictsSelectedForRemoval ? [] // uncheck them all
    : allDetectedConflicts // check them all
    : isCheckedForRemoval(md5) ? deleteList.filter(x => x !== md5) : [...deleteList, md5];
    dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_2__["updatePendingUnregisteredClientsForDeletion"])(newDeleteList));
  }

  function changeCheckForBlocking(md5, allDetectedConflicts) {
    const newBlocklist = 'all' === md5 ? allDetectedConflictsSelectedForBlocking ? [] // uncheck them all
    : allDetectedConflicts // check them all
    : isCheckedForBlocking(md5) ? blocklist.filter(x => x !== md5) : [...blocklist, md5];
    const orig = lodash_sortedUniq__WEBPACK_IMPORTED_MODULE_14___default()(savedBlocklist);
    const updated = lodash_sortedUniq__WEBPACK_IMPORTED_MODULE_14___default()(newBlocklist);

    if (orig.length === updated.length && 0 === lodash_size__WEBPACK_IMPORTED_MODULE_12___default()(lodash_difference__WEBPACK_IMPORTED_MODULE_15___default()(orig, updated)) && 0 === lodash_size__WEBPACK_IMPORTED_MODULE_12___default()(lodash_difference__WEBPACK_IMPORTED_MODULE_15___default()(updated, orig))) {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_2__["updatePendingBlocklist"])(null));
    } else {
      dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_2__["updatePendingBlocklist"])(newBlocklist));
    }
  }

  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()(_UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['unregistered-clients'], {
      [_UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['none-detected']]: !detectedUnregisteredClients
    })
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("h3", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['section-title']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('Other themes or plugins', 'font-awesome')), detectedUnregisteredClients ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['explanation']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('Below is the list of other versions of Font Awesome from active plugins or themes that are loading on your site. Check off any that you would like to block from loading. Normally this just blocks the conflicting version of Font Awesome and doesn\'t affect the other functions of the plugin, but you should verify your site works as expected. If you think you\'ve fixed a found conflict, you can clear it from the table.', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("table", {
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()('widefat', 'striped')
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("thead", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['table-header']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['column-label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('Block', 'font-awesome')), lodash_size__WEBPACK_IMPORTED_MODULE_12___default()(allDetectedConflicts) > 1 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['block-all-container']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "block_all_detected_conflicts",
    name: "block_all_detected_conflicts",
    type: "checkbox",
    value: "all",
    checked: allDetectedConflictsSelectedForBlocking,
    onChange: () => changeCheckForBlocking('all', allDetectedConflicts),
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['input-checkbox-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "block_all_detected_conflicts",
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['checkbox-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faCheckSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })), Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('All', 'font-awesome')))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['column-label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('Type', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['column-label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('URL', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("th", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['column-label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('Clear', 'font-awesome')), lodash_size__WEBPACK_IMPORTED_MODULE_12___default()(allDetectedConflicts) > 1 && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['remove-all-container']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: "remove_all_detected_conflicts",
    name: "remove_all_detected_conflicts",
    type: "checkbox",
    value: "all",
    checked: allDetectedConflictsSelectedForRemoval,
    onChange: () => changeCheckForRemoval('all', allDetectedConflicts),
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['input-checkbox-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: "remove_all_detected_conflicts",
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['checkbox-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faCheckSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })), Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('All', 'font-awesome')))))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tbody", null, allDetectedConflicts.map(md5 => /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("tr", {
    key: md5
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: `block_${md5}`,
    name: `block_${md5}`,
    type: "checkbox",
    value: md5,
    checked: isCheckedForBlocking(md5),
    onChange: () => changeCheckForBlocking(md5),
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['input-checkbox-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: `block_${md5}`,
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['checkbox-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faCheckSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  })))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, lodash_get__WEBPACK_IMPORTED_MODULE_10___default()(unregisteredClients[md5], 'tagName', 'unknown').toLowerCase()), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, unregisteredClients[md5].src || unregisteredClients[md5].href || Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_17__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('<em>in page source. </em><excerpt/>', 'font-awesome'), {
    em: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("em", null),
    excerpt: (content => content ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, "File starts with: ", /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("code", null, content)) : '')(excerpt(lodash_get__WEBPACK_IMPORTED_MODULE_10___default()(unregisteredClients[md5], 'innerText')))
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("td", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("input", {
    id: `remove_${md5}`,
    name: `remove_${md5}`,
    type: "checkbox",
    value: md5,
    checked: isCheckedForRemoval(md5),
    onChange: () => changeCheckForRemoval(md5),
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['sr-only'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['input-checkbox-custom'])
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("label", {
    htmlFor: `remove_${md5}`,
    className: _UnregisteredClientsView_module_css__WEBPACK_IMPORTED_MODULE_4__["default"]['checkbox-label']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['relative']
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faCheckSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['checked-icon'],
    size: "lg",
    fixedWidth: true
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_regular_svg_icons__WEBPACK_IMPORTED_MODULE_9__["faSquare"],
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['unchecked-icon'],
    size: "lg",
    fixedWidth: true
  }))))))))) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()(_App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['explanation'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['flex'], _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['flex-row'])
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_7__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_8__["faThumbsUp"],
    size: "lg"
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    className: _App_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['space-left']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_16__["__"])('We haven\'t detected any plugins or themes trying to load Font Awesome.', 'font-awesome'))));
}

/***/ }),

/***/ "./src/UnregisteredClientsView.module.css":
/*!************************************************!*\
  !*** ./src/UnregisteredClientsView.module.css ***!
  \************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"unregistered-clients":"UNNGEzMFNXhrxfnyioK07","column-label":"_2XKxHDPJPXCh6iEvgKgxC9","block-all-container":"_3lYi1K9O7ZubMKMUU7LvjT","remove-all-container":"_3JmSCzblQ9GifrOE7OyXRL","checkbox-label":"_215_d-1rWNQkl8wJIfnaWZ"});

/***/ }),

/***/ "./src/V3DeprecationWarning.js":
/*!*************************************!*\
  !*** ./src/V3DeprecationWarning.js ***!
  \*************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return V3DeprecationWarning; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @fortawesome/react-fontawesome */ "./node_modules/@fortawesome/react-fontawesome/index.es.js");
/* harmony import */ var _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @fortawesome/free-solid-svg-icons */ "./node_modules/@fortawesome/free-solid-svg-icons/index.es.js");
/* harmony import */ var _store_actions__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ./store/actions */ "./src/store/actions.js");
/* harmony import */ var _V3DeprecationWarning_module_css__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ./V3DeprecationWarning.module.css */ "./src/V3DeprecationWarning.module.css");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! classnames */ "./node_modules/classnames/index.js");
/* harmony import */ var classnames__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(classnames__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var _Alert__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! ./Alert */ "./src/Alert.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_8___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__);
/* harmony import */ var _createInterpolateElement__WEBPACK_IMPORTED_MODULE_9__ = __webpack_require__(/*! ./createInterpolateElement */ "./src/createInterpolateElement.js");










function V3DeprecationWarning() {
  const {
    snooze,
    atts,
    v5name,
    v5prefix
  } = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.v3DeprecationWarning);
  const {
    isSubmitting,
    hasSubmitted,
    success
  } = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useSelector"])(state => state.v3DeprecationWarningStatus);
  const dispatch = Object(react_redux__WEBPACK_IMPORTED_MODULE_1__["useDispatch"])();
  if (snooze) return null;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_Alert__WEBPACK_IMPORTED_MODULE_7__["default"], {
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Font Awesome 3 icon names are deprecated', 'font-awesome'),
    type: "warning"
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_9__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["sprintf"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Looks like you\'re using an old Font Awesome 3 icon name in your shortcode: <code>%s</code>. We discontinued support for Font Awesome 3 quite some time ago. Won\'t you jump into <a>the newest Font Awesome</a> with us? It\'s way better, and it\'s easy to upgrade.', 'font-awesome'), atts.name), {
    code: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("code", null),
    // eslint-disable-next-line jsx-a11y/anchor-has-content
    a: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
      rel: "noopener noreferrer",
      target: "_blank",
      href: "https://fontawesome.com/"
    })
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Just adjust your shortcode from this:', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("blockquote", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("code", null, "[icon name=\"", atts.name, "\"]")), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('to this:', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("blockquote", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("code", null, "[icon name=\"", v5name, "\" prefix=\"", v5prefix, "\"]")), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_9__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('You\'ll need to go adjust any version 3 icon names in [icon] shortcodes in your pages, posts, widgets, templates (or wherever they\'re coming from) to the new format with prefix. You can check the icon names and prefixes in our <linkIconGallery>Icon Gallery</linkIconGallery>. But what\'s that prefix, you ask? We now support a number of different styles for each icon. <linkLearnMore>Learn more</linkLearnMore>', 'font-awesome'), {
    // eslint-disable-next-line jsx-a11y/anchor-has-content
    linkIconGallery: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
      rel: "noopener noreferrer",
      target: "_blank",
      href: "https://fontawesome.com/icons?d=gallery"
    }),
    // eslint-disable-next-line jsx-a11y/anchor-has-content
    linkLearnMore: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
      rel: "noopener noreferrer",
      target: "_blank",
      href: "https://fontawesome.com/how-to-use/on-the-web/setup/upgrading-from-version-4#changes"
    })
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_9__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Once you update your icon shortcodes, this warning will disappear or you could hit snooze to hide it for a while. <strong>But we\'re gonna remove this v3-to-v5 magic soon, though, so don\'t wait forever.</strong>', 'font-awesome'), {
    strong: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("strong", null)
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("p", null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("button", {
    disabled: isSubmitting,
    onClick: () => dispatch(Object(_store_actions__WEBPACK_IMPORTED_MODULE_4__["snoozeV3DeprecationWarning"])()),
    className: classnames__WEBPACK_IMPORTED_MODULE_6___default()(_V3DeprecationWarning_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['snooze-button'], 'button', 'button-primary')
  }, isSubmitting ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_2__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_3__["faSpinner"],
    spin: true,
    className: _V3DeprecationWarning_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['submitting']
  }) : hasSubmitted ? success ? /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_2__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_3__["faCheck"],
    className: _V3DeprecationWarning_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['success']
  }) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_2__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_3__["faSkull"],
    className: _V3DeprecationWarning_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['fail']
  }) : /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_react_fontawesome__WEBPACK_IMPORTED_MODULE_2__["FontAwesomeIcon"], {
    icon: _fortawesome_free_solid_svg_icons__WEBPACK_IMPORTED_MODULE_3__["faClock"],
    className: _V3DeprecationWarning_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['snooze']
  }), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    className: _V3DeprecationWarning_module_css__WEBPACK_IMPORTED_MODULE_5__["default"]['label']
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_8__["__"])('Snooze', 'font-awesome')))));
}

/***/ }),

/***/ "./src/V3DeprecationWarning.module.css":
/*!*********************************************!*\
  !*** ./src/V3DeprecationWarning.module.css ***!
  \*********************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
// extracted by mini-css-extract-plugin
/* harmony default export */ __webpack_exports__["default"] = ({"v3-deprecation-warning":"_1ddwDDFvWAmIUb5J85yQxm","snooze-button":"_3xIAE8P7wsJ1e6tt0-DqIp","label":"_16T4IbgsUtAU_f8-gOSVSO"});

/***/ }),

/***/ "./src/createInterpolateElement.js":
/*!*****************************************!*\
  !*** ./src/createInterpolateElement.js ***!
  \*****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_0__);

const createInterpolateElement = _wordpress_element__WEBPACK_IMPORTED_MODULE_0__["createInterpolateElement"] || _wordpress_element__WEBPACK_IMPORTED_MODULE_0__["__experimentalCreateInterpolateElement"];
/* harmony default export */ __webpack_exports__["default"] = (createInterpolateElement);

/***/ }),

/***/ "./src/mountAdminView.js":
/*!*******************************!*\
  !*** ./src/mountAdminView.js ***!
  \*******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _ErrorBoundary__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ErrorBoundary */ "./src/ErrorBoundary.js");
/* harmony import */ var _FontAwesomeAdminView__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./FontAwesomeAdminView */ "./src/FontAwesomeAdminView.js");
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/dom-ready */ "@wordpress/dom-ready");
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_5__);






/* harmony default export */ __webpack_exports__["default"] = (function (store) {
  _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_5___default()(() => react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render( /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_ErrorBoundary__WEBPACK_IMPORTED_MODULE_2__["default"], null, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react_redux__WEBPACK_IMPORTED_MODULE_4__["Provider"], {
    store: store
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_FontAwesomeAdminView__WEBPACK_IMPORTED_MODULE_3__["default"], null))), document.getElementById('font-awesome-admin')));
});

/***/ }),

/***/ "./src/mountConflictDetectionReporter.js":
/*!***********************************************!*\
  !*** ./src/mountConflictDetectionReporter.js ***!
  \***********************************************/
/*! exports provided: CONFLICT_DETECTION_SHADOW_HOST_ID, mountConflictDetectionReporter, isConflictDetectionReporterMounted */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CONFLICT_DETECTION_SHADOW_HOST_ID", function() { return CONFLICT_DETECTION_SHADOW_HOST_ID; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "mountConflictDetectionReporter", function() { return mountConflictDetectionReporter; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "isConflictDetectionReporterMounted", function() { return isConflictDetectionReporterMounted; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _ConflictDetectionReporter__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./ConflictDetectionReporter */ "./src/ConflictDetectionReporter.js");
/* harmony import */ var _fortawesome_fontawesome_svg_core__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @fortawesome/fontawesome-svg-core */ "./node_modules/@fortawesome/fontawesome-svg-core/index.es.js");
/* harmony import */ var react_redux__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! react-redux */ "./node_modules/react-redux/es/index.js");
/* harmony import */ var react_shadow_dom_retarget_events__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! react-shadow-dom-retarget-events */ "./node_modules/react-shadow-dom-retarget-events/index.js");
/* harmony import */ var react_shadow_dom_retarget_events__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(react_shadow_dom_retarget_events__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/dom-ready */ "@wordpress/dom-ready");
/* harmony import */ var _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_6__);







const CONFLICT_DETECTION_SHADOW_HOST_ID = 'font-awesome-plugin-conflict-detection-shadow-host';
function mountConflictDetectionReporter(store) {
  _wordpress_dom_ready__WEBPACK_IMPORTED_MODULE_6___default()(() => {
    const conflictDetectionShadowRootElement = document.createElement('DIV');
    conflictDetectionShadowRootElement.setAttribute('id', CONFLICT_DETECTION_SHADOW_HOST_ID);
    document.body.appendChild(conflictDetectionShadowRootElement);
    const shadow = conflictDetectionShadowRootElement.attachShadow({
      mode: 'open'
    }); // React doesn't seem to natively handle click events that originate inside
    // a shadow DOM. This utility will cause things to work like you'd expect.
    // See: https://github.com/spring-media/react-shadow-dom-retarget-events

    react_shadow_dom_retarget_events__WEBPACK_IMPORTED_MODULE_5___default()(shadow);
    const faStyle = document.createElement('STYLE');
    const css = _fortawesome_fontawesome_svg_core__WEBPACK_IMPORTED_MODULE_3__["dom"].css();
    const cssText = document.createTextNode(css);
    faStyle.appendChild(cssText);
    const shadowContainer = document.createElement('DIV');
    shadow.appendChild(faStyle);
    shadow.appendChild(shadowContainer);
    react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render( /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react_redux__WEBPACK_IMPORTED_MODULE_4__["Provider"], {
      store: store
    }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_ConflictDetectionReporter__WEBPACK_IMPORTED_MODULE_2__["default"], null)), shadowContainer);
  });
}
function isConflictDetectionReporterMounted() {
  const shadowHost = document.getElementById(CONFLICT_DETECTION_SHADOW_HOST_ID);
  if (!shadowHost) return false;
  return !!shadowHost.shadowRoot;
}

/***/ }),

/***/ "./src/store/actions.js":
/*!******************************!*\
  !*** ./src/store/actions.js ***!
  \******************************/
/*! exports provided: CONFLICT_DETECTION_SCANNER_DURATION_MIN, resetPendingOptions, resetOptionsFormState, addPendingOption, updatePendingUnregisteredClientsForDeletion, resetUnregisteredClientsDeletionStatus, resetPendingBlocklistSubmissionStatus, submitPendingUnregisteredClientDeletions, updatePendingBlocklist, submitPendingBlocklist, checkPreferenceConflicts, chooseAwayFromKitConfig, chooseIntoKitConfig, queryKits, submitPendingOptions, updateApiToken, userAttemptToStopScanner, reportDetectedConflicts, snoozeV3DeprecationWarning, setActiveAdminTab, setConflictDetectionScanner */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "CONFLICT_DETECTION_SCANNER_DURATION_MIN", function() { return CONFLICT_DETECTION_SCANNER_DURATION_MIN; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "resetPendingOptions", function() { return resetPendingOptions; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "resetOptionsFormState", function() { return resetOptionsFormState; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "addPendingOption", function() { return addPendingOption; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "updatePendingUnregisteredClientsForDeletion", function() { return updatePendingUnregisteredClientsForDeletion; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "resetUnregisteredClientsDeletionStatus", function() { return resetUnregisteredClientsDeletionStatus; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "resetPendingBlocklistSubmissionStatus", function() { return resetPendingBlocklistSubmissionStatus; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "submitPendingUnregisteredClientDeletions", function() { return submitPendingUnregisteredClientDeletions; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "updatePendingBlocklist", function() { return updatePendingBlocklist; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "submitPendingBlocklist", function() { return submitPendingBlocklist; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "checkPreferenceConflicts", function() { return checkPreferenceConflicts; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "chooseAwayFromKitConfig", function() { return chooseAwayFromKitConfig; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "chooseIntoKitConfig", function() { return chooseIntoKitConfig; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "queryKits", function() { return queryKits; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "submitPendingOptions", function() { return submitPendingOptions; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "updateApiToken", function() { return updateApiToken; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "userAttemptToStopScanner", function() { return userAttemptToStopScanner; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "reportDetectedConflicts", function() { return reportDetectedConflicts; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "snoozeV3DeprecationWarning", function() { return snoozeV3DeprecationWarning; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setActiveAdminTab", function() { return setActiveAdminTab; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setConflictDetectionScanner", function() { return setConflictDetectionScanner; });
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash_toPairs__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash/toPairs */ "./node_modules/lodash/toPairs.js");
/* harmony import */ var lodash_toPairs__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash_toPairs__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var lodash_find__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash/find */ "./node_modules/lodash/find.js");
/* harmony import */ var lodash_find__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash_find__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! ../util/reportRequestError */ "./src/util/reportRequestError.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__);
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_7__ = __webpack_require__(/*! lodash/has */ "./node_modules/lodash/has.js");
/* harmony import */ var lodash_has__WEBPACK_IMPORTED_MODULE_7___default = /*#__PURE__*/__webpack_require__.n(lodash_has__WEBPACK_IMPORTED_MODULE_7__);
/* harmony import */ var _util_sliceJson__WEBPACK_IMPORTED_MODULE_8__ = __webpack_require__(/*! ../util/sliceJson */ "./src/util/sliceJson.js");









const restApiAxios = axios__WEBPACK_IMPORTED_MODULE_0___default.a.create(); // How far into the future from "now" until the conflict detection scanner
// will be enabled.

const CONFLICT_DETECTION_SCANNER_DURATION_MIN = 10; // How far in the past to set detectConflictsUntil when the conflict detection
// scanner is being disabled. We can use a non-zero but negligible value in
// order to protect against possible race conditions, instead of 0
// (which would just be exactly "now").

const CONFLICT_DETECTION_SCANNER_DEACTIVATION_DELTA_MS = 1;

const COULD_NOT_SAVE_CHANGES_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Couldn\'t save those changes', 'font-awesome');

const COULD_NOT_CHECK_PREFERENCES_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Couldn\'t check preferences', 'font-awesome');

const NO_RESPONSE_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('A request to your WordPress server never received a response', 'font-awesome');

const REQUEST_FAILED_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('A request to your WordPress server failed', 'font-awesome');

const COULD_NOT_START_SCANNER_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Couldn\'t start the scanner', 'font-awesome');

const COULD_NOT_SNOOZE_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Couldn\'t snooze', 'font-awesome');

function preprocessResponse(response) {
  const confirmed = lodash_has__WEBPACK_IMPORTED_MODULE_7___default()(response, 'headers.fontawesome-confirmation');

  if (204 === response.status && '' !== response.data) {
    Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
      error: null,
      confirmed,
      trimmed: response.data,
      expectEmpty: true
    }); // clean it up

    response.data = {};
    return response;
  }

  const data = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(response, 'data', null);
  const foundUnexpectedData = 'string' === typeof data && lodash_size__WEBPACK_IMPORTED_MODULE_2___default()(data) > 0;
  const sliced = foundUnexpectedData ? Object(_util_sliceJson__WEBPACK_IMPORTED_MODULE_8__["default"])(data) : {}; // Fixup the response data if garbage was fixed

  if (foundUnexpectedData) {
    if (null === sliced) {
      Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
        error: null,
        confirmed,
        trimmed: data
      }); // clean it up

      response.data = {};
      return response;
    } else {
      response.data = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(sliced, 'parsed');
    }
  } // If we had to trim any garbage, we'll store it here


  const trimmed = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(sliced, 'trimmed', '');
  const errors = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(response, 'data.errors', null);

  if (response.status >= 400) {
    if (errors) {
      // This is just a normal error response.
      response.uiMessage = Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
        error: response.data,
        confirmed,
        trimmed
      });
    } else {
      // This error response has a bad schema
      response.uiMessage = Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
        error: null,
        confirmed,
        trimmed
      });
    }

    return response;
  }
  /**
   * We don't normally expect 3XX responses, but we'll just let it pass
   * through, unless we can see that the response has been corrupted,
   * in which case we'll report that first.
   */


  if (response.status < 400 && response.status >= 300) {
    if (!confirmed || '' !== trimmed) {
      response.uiMessage = Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
        error: null,
        confirmed,
        trimmed
      });
    }

    return response;
  }
  /**
   * If we make it this far, then we have a 2XX response with some valid data,
   * which we maybe had to fix up.
   *
   * Now we need to detect whether it contains any errors to identify false positives,
   * or cases where its legitmate for the controller to return an otherwise
   * successful response that also includes some error data for extra diagnostics.
   */


  if (errors) {
    /** 
     * The controller sent back _only_ error data, though the HTTP status is 2XX.
     * This is a false positive.
     * This can occur when other buggy code running on the WordPress server preempts
     * and undermines the proper sending of HTTP headers, and yet the controller
     * still sends its otherwise-valid JSON error response.
     */
    const falsePositive = true;
    response.falsePositive = true;
    response.uiMessage = Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
      error: response.data,
      confirmed,
      falsePositive,
      trimmed
    });
    return response;
  } else {
    const error = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(response, 'data.error', null);

    if (error) {
      /**
       * We may receive errors back with a 200 success response, such as when
       * the controller catches PreferenceRegistrationExceptions.
       */
      response.uiMessage = Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
        error,
        ok: true,
        confirmed,
        trimmed
      });
      return response;
    }

    if (!confirmed) {
      /**
       * We have received a response that, by every indication so far, is successful.
       * However, it lacks the confirmation header, which _might_ indicate a problem.
       */
      response.uiMessage = Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
        error: null,
        ok: true,
        confirmed,
        trimmed
      });
    }

    return response;
  }
}

restApiAxios.interceptors.response.use(response => preprocessResponse(response), error => {
  if (error.response) {
    error.response = preprocessResponse(error.response);
    error.uiMessage = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(error, 'response.uiMessage');
  } else if (error.request) {
    const code = 'fontawesome_request_noresponse';
    const e = {
      errors: {
        [code]: [NO_RESPONSE_MESSAGE]
      },
      error_data: {
        [code]: {
          request: error.request
        }
      }
    };
    error.uiMessage = Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
      error: e
    });
  } else {
    const code = 'fontawesome_request_failed';
    const e = {
      errors: {
        [code]: [REQUEST_FAILED_MESSAGE]
      },
      error_data: {
        [code]: {
          failedRequestMessage: error.message
        }
      }
    };
    error.uiMessage = Object(_util_reportRequestError__WEBPACK_IMPORTED_MODULE_5__["default"])({
      error: e
    });
  }

  return Promise.reject(error);
});
function resetPendingOptions() {
  return {
    type: 'RESET_PENDING_OPTIONS'
  };
}
function resetOptionsFormState() {
  return {
    type: 'OPTIONS_FORM_STATE_RESET'
  };
}
function addPendingOption(change) {
  return function (dispatch, getState) {
    const {
      options
    } = getState();

    for (const [key, val] of lodash_toPairs__WEBPACK_IMPORTED_MODULE_1___default()(change)) {
      const originalValue = options[key]; // If we're changing back to an original setting

      if (originalValue === val) {
        dispatch({
          type: 'RESET_PENDING_OPTION',
          change: {
            [key]: val
          }
        });
      } else {
        dispatch({
          type: 'ADD_PENDING_OPTION',
          change: {
            [key]: val
          }
        });
      }
    }
  };
}
function updatePendingUnregisteredClientsForDeletion(data = []) {
  return {
    type: 'UPDATE_PENDING_UNREGISTERED_CLIENTS_FOR_DELETION',
    data
  };
}
function resetUnregisteredClientsDeletionStatus() {
  return {
    type: 'DELETE_UNREGISTERED_CLIENTS_RESET'
  };
}
function resetPendingBlocklistSubmissionStatus() {
  return {
    type: 'BLOCKLIST_UPDATE_RESET'
  };
}
function submitPendingUnregisteredClientDeletions() {
  return function (dispatch, getState) {
    const {
      apiNonce,
      apiUrl,
      unregisteredClientsDeletionStatus
    } = getState();
    const deleteList = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(unregisteredClientsDeletionStatus, 'pending', null);
    if (!deleteList || lodash_size__WEBPACK_IMPORTED_MODULE_2___default()(deleteList) === 0) return;
    dispatch({
      type: 'DELETE_UNREGISTERED_CLIENTS_START'
    });

    const handleError = ({
      uiMessage
    }) => {
      dispatch({
        type: 'DELETE_UNREGISTERED_CLIENTS_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      });
    };

    return restApiAxios.delete(`${apiUrl}/conflict-detection/conflicts`, {
      data: deleteList,
      headers: {
        'X-WP-Nonce': apiNonce
      }
    }).then(response => {
      const {
        status,
        data,
        falsePositive
      } = response;

      if (falsePositive) {
        handleError(response);
      } else {
        dispatch({
          type: 'DELETE_UNREGISTERED_CLIENTS_END',
          success: true,
          data: 204 === status ? null : data,
          message: ''
        });
      }
    }).catch(handleError);
  };
}
function updatePendingBlocklist(data = []) {
  return {
    type: 'UPDATE_PENDING_BLOCKLIST',
    data
  };
}
function submitPendingBlocklist() {
  return function (dispatch, getState) {
    const {
      apiNonce,
      apiUrl,
      blocklistUpdateStatus
    } = getState();
    const blocklist = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(blocklistUpdateStatus, 'pending', null);
    if (!blocklist) return;
    dispatch({
      type: 'BLOCKLIST_UPDATE_START'
    });

    const handleError = ({
      uiMessage
    }) => {
      dispatch({
        type: 'BLOCKLIST_UPDATE_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      });
    };

    return restApiAxios.put(`${apiUrl}/conflict-detection/conflicts/blocklist`, blocklist, {
      headers: {
        'X-WP-Nonce': apiNonce
      }
    }).then(response => {
      const {
        status,
        data,
        falsePositive
      } = response;

      if (falsePositive) {
        handleError(response);
      } else {
        dispatch({
          type: 'BLOCKLIST_UPDATE_END',
          success: true,
          data: 204 === status ? null : data,
          message: ''
        });
      }
    }).catch(handleError);
  };
}
function checkPreferenceConflicts() {
  return function (dispatch, getState) {
    dispatch({
      type: 'PREFERENCE_CHECK_START'
    });
    const {
      apiNonce,
      apiUrl,
      options,
      pendingOptions
    } = getState();

    const handleError = ({
      uiMessage
    }) => {
      dispatch({
        type: 'PREFERENCE_CHECK_END',
        success: false,
        message: uiMessage || COULD_NOT_CHECK_PREFERENCES_MESSAGE
      });
    };

    return restApiAxios.post(`${apiUrl}/preference-check`, { ...options,
      ...pendingOptions
    }, {
      headers: {
        'X-WP-Nonce': apiNonce
      }
    }).then(response => {
      const {
        data,
        falsePositive
      } = response;

      if (falsePositive) {
        handleError(response);
      } else {
        dispatch({
          type: 'PREFERENCE_CHECK_END',
          success: true,
          message: '',
          detectedConflicts: data
        });
      }
    }).catch(handleError);
  };
}
function chooseAwayFromKitConfig({
  activeKitToken
}) {
  return function (dispatch, getState) {
    const {
      releases
    } = getState();
    dispatch({
      type: 'CHOOSE_AWAY_FROM_KIT_CONFIG',
      activeKitToken,
      concreteVersion: lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(releases, 'latest_version')
    });
  };
}
function chooseIntoKitConfig() {
  return {
    type: 'CHOOSE_INTO_KIT_CONFIG'
  };
}
function queryKits() {
  return function (dispatch, getState) {
    const {
      apiNonce,
      apiUrl,
      options
    } = getState();
    const initialKitToken = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(options, 'kitToken', null);
    dispatch({
      type: 'KITS_QUERY_START'
    });

    const handleKitsQueryError = ({
      uiMessage
    }) => {
      dispatch({
        type: 'KITS_QUERY_END',
        success: false,
        message: uiMessage || Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Failed to fetch kits', 'font-awesome')
      });
    };

    const handleKitUpdateError = ({
      uiMessage
    }) => {
      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: uiMessage || Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Couldn\'t update latest kit settings', 'font-awesome')
      });
    };

    return restApiAxios.post(`${apiUrl}/api`, `query {
        me {
          kits {
            name
            version
            technologySelected
            licenseSelected
            minified
            token
            shimEnabled
            autoAccessibilityEnabled
            status
          }
        }
      }`, {
      headers: {
        'X-WP-Nonce': apiNonce
      }
    }).then(response => {
      if (response.falsePositive) return handleKitsQueryError(response);
      const data = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(response, 'data.data'); // We may receive errors back with a 200 response, such as when
      // there PreferenceRegistrationExceptions.

      if (lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(data, 'me')) {
        dispatch({
          type: 'KITS_QUERY_END',
          data,
          success: true
        });
      } else {
        return dispatch({
          type: 'KITS_QUERY_END',
          success: false,
          message: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Failed to fetch kits. Regenerate your API Token and try again.', 'font-awesome')
        });
      } // If we didn't start out with a saved kitToken, we're done.
      // Otherwise, we'll move on to update any config on that kit which
      // might have changed since we saved it in WordPress.


      if (!initialKitToken) return;
      const refreshedKits = lodash_get__WEBPACK_IMPORTED_MODULE_3___default()(data, 'me.kits', []);
      const currentKitRefreshed = lodash_find__WEBPACK_IMPORTED_MODULE_4___default()(refreshedKits, {
        token: initialKitToken
      });
      if (!currentKitRefreshed) return;
      const optionsUpdate = {}; // Inspect each relevant kit option for the current kit to see if it's
      // been changed since our last query.

      if (options.usePro && currentKitRefreshed.licenseSelected !== 'pro') {
        optionsUpdate.usePro = false;
      } else if (!options.usePro && currentKitRefreshed.licenseSelected === 'pro') {
        optionsUpdate.usePro = true;
      }

      if (options.technology === 'svg' && currentKitRefreshed.technologySelected !== 'svg') {
        optionsUpdate.technology = 'webfont'; // pseudoElements must always be true for webfont

        optionsUpdate.pseudoElements = true;
      } else if (options.technology !== 'svg' && currentKitRefreshed.technologySelected === 'svg') {
        optionsUpdate.technology = 'svg'; // pseudoElements must always be false for svg when loaded in a kit

        optionsUpdate.pseudoElements = false;
      }

      if (options.version !== currentKitRefreshed.version) {
        optionsUpdate.version = currentKitRefreshed.version;
      }

      if (options.v4Compat && !currentKitRefreshed.shimEnabled) {
        optionsUpdate.v4Compat = false;
      } else if (!options.v4Compat && currentKitRefreshed.shimEnabled) {
        optionsUpdate.v4Compat = true;
      }

      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_START'
      });
      return restApiAxios.put(`${apiUrl}/config`, {
        options: { ...options,
          ...optionsUpdate
        }
      }, {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }).then(response => {
        const {
          data,
          falsePositive
        } = response;
        if (falsePositive) return handleKitUpdateError(response);
        dispatch({
          type: 'OPTIONS_FORM_SUBMIT_END',
          data,
          success: true,
          message: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Kit changes saved', 'font-awesome')
        });
      }).catch(handleKitUpdateError);
    }).catch(handleKitsQueryError);
  };
}
function submitPendingOptions() {
  return function (dispatch, getState) {
    const {
      apiNonce,
      apiUrl,
      options,
      pendingOptions
    } = getState();
    dispatch({
      type: 'OPTIONS_FORM_SUBMIT_START'
    });

    const handleError = ({
      uiMessage
    }) => {
      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      });
    };

    return restApiAxios.put(`${apiUrl}/config`, {
      options: { ...options,
        ...pendingOptions
      }
    }, {
      headers: {
        'X-WP-Nonce': apiNonce
      }
    }).then(response => {
      const {
        data,
        falsePositive
      } = response;

      if (falsePositive) {
        handleError(response);
      } else {
        dispatch({
          type: 'OPTIONS_FORM_SUBMIT_END',
          data,
          success: true,
          message: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('Changes saved', 'font-awesome')
        });
      }
    }).catch(handleError);
  };
}
function updateApiToken({
  apiToken = false,
  runQueryKits = false
}) {
  return function (dispatch, getState) {
    const {
      apiNonce,
      apiUrl,
      options
    } = getState();
    dispatch({
      type: 'OPTIONS_FORM_SUBMIT_START'
    });

    const handleError = ({
      uiMessage
    }) => {
      dispatch({
        type: 'OPTIONS_FORM_SUBMIT_END',
        success: false,
        message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
      });
    };

    return restApiAxios.put(`${apiUrl}/config`, {
      options: { ...options,
        apiToken
      }
    }, {
      headers: {
        'X-WP-Nonce': apiNonce
      }
    }).then(response => {
      const {
        data,
        falsePositive
      } = response;

      if (falsePositive) {
        handleError(response);
      } else {
        dispatch({
          type: 'OPTIONS_FORM_SUBMIT_END',
          data,
          success: true,
          message: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_6__["__"])('API Token saved', 'font-awesome')
        });

        if (runQueryKits) {
          return dispatch(queryKits());
        }
      }
    }).catch(handleError);
  };
}
function userAttemptToStopScanner() {
  return {
    type: 'USER_STOP_SCANNER'
  };
}
function reportDetectedConflicts({
  nodesTested = {}
}) {
  return (dispatch, getState) => {
    const {
      apiNonce,
      apiUrl,
      unregisteredClients,
      showConflictDetectionReporter
    } = getState(); // This should be a noop if by the time we get here the conflict detection reporter
    // is already gone. That would indicate that the user stopped the scanner before
    // the current page's scan was complete and report submitted. In that case,
    // we just ignore the report. Otherwise, this action would try to post results
    // to a REST route that will no longer be registered and listening, resulting a 404.

    if (!showConflictDetectionReporter) {
      return;
    }

    if (lodash_size__WEBPACK_IMPORTED_MODULE_2___default()(nodesTested.conflict) > 0) {
      const payload = Object.keys(nodesTested.conflict).reduce(function (acc, md5) {
        acc[md5] = nodesTested.conflict[md5];
        return acc;
      }, {});
      dispatch({
        type: 'CONFLICT_DETECTION_SUBMIT_START',
        unregisteredClientsBeforeDetection: unregisteredClients,
        recentConflictsDetected: nodesTested.conflict
      });

      const handleError = ({
        uiMessage
      }) => {
        dispatch({
          type: 'CONFLICT_DETECTION_SUBMIT_END',
          success: false,
          message: uiMessage || COULD_NOT_SAVE_CHANGES_MESSAGE
        });
      };

      return restApiAxios.post(`${apiUrl}/conflict-detection/conflicts`, payload, {
        headers: {
          'X-WP-Nonce': apiNonce
        }
      }).then(response => {
        const {
          status,
          data,
          falsePositive
        } = response;

        if (falsePositive) {
          handleError(response);
        } else {
          dispatch({
            type: 'CONFLICT_DETECTION_SUBMIT_END',
            success: true,

            /**
             * If get back no data here, that can only mean that a previous
             * response with garbage in it had an erroneous HTTP 200 status
             * on it, but no parseable JSON, which is equivalent to a 204.
             */
            data: 204 === status || 0 === lodash_size__WEBPACK_IMPORTED_MODULE_2___default()(data) ? null : data
          });
        }
      }).catch(handleError);
    } else {
      dispatch({
        type: 'CONFLICT_DETECTION_NONE_FOUND'
      });
    }
  };
}
function snoozeV3DeprecationWarning() {
  return (dispatch, getState) => {
    const {
      apiNonce,
      apiUrl
    } = getState();
    dispatch({
      type: 'SNOOZE_V3DEPRECATION_WARNING_START'
    });

    const handleError = ({
      uiMessage
    }) => {
      dispatch({
        type: 'SNOOZE_V3DEPRECATION_WARNING_END',
        success: false,
        message: uiMessage || COULD_NOT_SNOOZE_MESSAGE
      });
    };

    return restApiAxios.put(`${apiUrl}/v3deprecation`, {
      snooze: true
    }, {
      headers: {
        'X-WP-Nonce': apiNonce
      }
    }).then(response => {
      const {
        falsePositive
      } = response;

      if (falsePositive) {
        handleError(response);
      } else {
        dispatch({
          type: 'SNOOZE_V3DEPRECATION_WARNING_END',
          success: true,
          snooze: true,
          message: ''
        });
      }
    }).catch(handleError);
  };
}
function setActiveAdminTab(tab) {
  return {
    type: 'SET_ACTIVE_ADMIN_TAB',
    tab
  };
}
function setConflictDetectionScanner({
  enable = true
}) {
  return function (dispatch, getState) {
    const {
      apiNonce,
      apiUrl
    } = getState();
    const actionStartType = enable ? 'ENABLE_CONFLICT_DETECTION_SCANNER_START' : 'DISABLE_CONFLICT_DETECTION_SCANNER_START';
    const actionEndType = enable ? 'ENABLE_CONFLICT_DETECTION_SCANNER_END' : 'DISABLE_CONFLICT_DETECTION_SCANNER_END';
    dispatch({
      type: actionStartType
    });

    const handleError = ({
      uiMessage
    }) => {
      dispatch({
        type: actionEndType,
        success: false,
        message: uiMessage || COULD_NOT_START_SCANNER_MESSAGE
      });
    };

    return restApiAxios.put(`${apiUrl}/conflict-detection/until`, enable ? Math.floor(new Date(new Date().valueOf() + CONFLICT_DETECTION_SCANNER_DURATION_MIN * 1000 * 60) / 1000) : Math.floor(new Date() / 1000) - CONFLICT_DETECTION_SCANNER_DEACTIVATION_DELTA_MS, {
      headers: {
        'X-WP-Nonce': apiNonce
      }
    }).then(response => {
      const {
        status,
        data,
        falsePositive
      } = response;

      if (falsePositive) {
        handleError(response);
      } else {
        dispatch({
          type: actionEndType,
          data: 204 === status ? null : data,
          success: true
        });
      }
    }).catch(handleError);
  };
}

/***/ }),

/***/ "./src/util/reportRequestError.js":
/*!****************************************!*\
  !*** ./src/util/reportRequestError.js ***!
  \****************************************/
/*! exports provided: ERROR_REPORT_PREAMBLE, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ERROR_REPORT_PREAMBLE", function() { return ERROR_REPORT_PREAMBLE; });
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! lodash/size */ "./node_modules/lodash/size.js");
/* harmony import */ var lodash_size__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(lodash_size__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__);



const ERROR_REPORT_PREAMBLE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('Font Awesome WordPress Plugin Error Report', 'font-awesome');

const UI_MESSAGE_DEFAULT = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('D\'oh! That failed big time.', 'font-awesome');

const ERROR_REPORTING_ERROR = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('There was an error attempting to report the error.', 'font-awesome');

const REST_NO_ROUTE_ERROR = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('Oh no! Your web browser could not reach your WordPress server.', 'font-awesome');

const REST_COOKIE_INVALID_NONCE_ERROR = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('It looks like your web browser session expired. Try logging out and log back in to WordPress admin.', 'font-awesome');

const OK_ERROR_PREAMBLE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('The last request was successful, but it also returned the following error(s), which might be helpful for troubleshooting.', 'font-awesome');

const ONE_OF_MANY_ERRORS_GROUP_LABEL = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('Error', 'font-awesome');

const FALSE_POSITIVE_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('WARNING: The last request contained errors, though your WordPress server reported it as a success. This usually means there\'s a problem with your theme or one of your other plugins emitting output that is causing problems.', 'font-awesome');

const UNCONFIRMED_RESPONSE_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('WARNING: The last response from your WordPress server did not include the confirmation header that should be in all valid Font Awesome responses. This is a clue that some code from another theme or plugin is acting badly and causing the wrong headers to be sent.', 'font-awesome');

const TRIMMED_RESPONSE_PREAMBLE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('WARNING: Invalid Data Trimmed from Server Response', 'font-awesome');

const EXPECTED_EMPTY_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('WARNING: We expected the last response from the server to contain no data, but it contained something unexpected.', 'font-awesome');

const MISSING_ERROR_DATA_MESSAGE = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_2__["__"])('Your WordPress server returned an error for that last request, but there was no information about the error.', 'font-awesome');
/**
 * This both sends appropriately formatted output to the console via console.info,
 * and returns a uiMessage that would be appropriate to display to an admin user.
 */


function handleSingleWpErrorOutput(wpError) {
  if (!lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(wpError, 'code')) {
    console.info(ERROR_REPORTING_ERROR);
    return UI_MESSAGE_DEFAULT;
  }

  let uiMessage = null;
  let output = '';
  const message = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(wpError, 'message');

  if (message) {
    output = output.concat(`message: ${message}\n`);
    uiMessage = message;
  }

  const code = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(wpError, 'code');

  if (code) {
    output = output.concat(`code: ${code}\n`);

    switch (code) {
      case 'rest_no_route':
        uiMessage = REST_NO_ROUTE_ERROR;
        break;

      case 'rest_cookie_invalid_nonce':
        uiMessage = REST_COOKIE_INVALID_NONCE_ERROR;
        break;

      case 'fontawesome_unknown_error':
        uiMessage = UI_MESSAGE_DEFAULT;
        break;

      default:
    }
  }

  const data = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(wpError, 'data');

  if ('string' === typeof data) {
    output = output.concat(`data: ${data}\n`);
  } else {
    const status = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(wpError, 'data.status');
    if (status) output = output.concat(`status: ${status}\n`);
    const trace = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(wpError, 'data.trace');
    if (trace) output = output.concat(`trace:\n${trace}\n`);
  }

  if (output && '' !== output) {
    console.info(output);
  } else {
    console.info(wpError);
  }

  const request = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(wpError, 'data.request');

  if (request) {
    console.info(request);
  }

  const failedRequestMessage = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(wpError, 'data.failedRequestMessage');

  if (failedRequestMessage) {
    console.info(failedRequestMessage);
  }

  return uiMessage;
}

function handleAllWpErrorOutput(errorData) {
  const wpErrors = Object.keys(errorData.errors || []).map(code => {
    // get the first error message available for this code
    const message = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(errorData, `errors.${code}.0`);
    const data = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(errorData, `error_data.${code}`);
    return {
      code,
      message,
      data
    };
  });

  if (0 === lodash_size__WEBPACK_IMPORTED_MODULE_1___default()(wpErrors)) {
    wpErrors.push({
      code: 'fontawesome_unknown_error',
      message: ERROR_REPORTING_ERROR
    });
  }

  const uiMessage = wpErrors.reduce((acc, error) => {
    console.group(ONE_OF_MANY_ERRORS_GROUP_LABEL);
    const msg = handleSingleWpErrorOutput(error);
    console.groupEnd(); // The uiMessage we should return will be the first error message that isn't
    // from a 'previous_exception'

    return !acc && error.code !== 'previous_exception' ? msg : acc;
  }, null);
  return uiMessage;
}

function report(params) {
  const {
    error,
    ok = false,
    falsePositive = false,
    confirmed = true,
    expectEmpty = false,
    trimmed = ''
  } = params;
  console.group(ERROR_REPORT_PREAMBLE);

  if (ok) {
    console.info(OK_ERROR_PREAMBLE);
  }

  if (falsePositive) {
    console.info(FALSE_POSITIVE_MESSAGE);
  }

  if (!confirmed) {
    console.info(UNCONFIRMED_RESPONSE_MESSAGE);
  }

  if ('' !== trimmed) {
    console.group(TRIMMED_RESPONSE_PREAMBLE);

    if (expectEmpty) {
      console.info(EXPECTED_EMPTY_MESSAGE);
    }

    console.info(trimmed);
    console.groupEnd();
  }

  const uiMessage = null !== error ? handleAllWpErrorOutput(error) : null;

  if (null === error && trimmed === '' && confirmed) {
    console.info(MISSING_ERROR_DATA_MESSAGE);
  }

  console.groupEnd();
  return uiMessage;
}

/* harmony default export */ __webpack_exports__["default"] = (report);

/***/ }),

/***/ "./src/util/sliceJson.js":
/*!*******************************!*\
  !*** ./src/util/sliceJson.js ***!
  \*******************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
function findJson(content, start = 0) {
  let parsed = null;
  let nextStart = null;
  if ('string' !== typeof content) return null;
  if (start >= content.length) return null;

  try {
    parsed = JSON.parse(content.slice(start));
    return {
      start,
      parsed
    };
  } catch (_e) {
    // search for the next character that would begin a JSON response
    const nextLeftBracket = content.indexOf('[', start + 1);
    const nextLeftBrace = content.indexOf('{', start + 1);

    if (-1 === nextLeftBracket && -1 === nextLeftBrace) {
      // we've search to the end and found no chars that would start JSON content
      return null;
    } else {
      if (-1 !== nextLeftBracket && -1 !== nextLeftBrace) {
        // if we found both, take the lower one
        nextStart = nextLeftBracket < nextLeftBrace ? nextLeftBracket : nextLeftBrace;
      } else if (-1 !== nextLeftBrace) {
        nextStart = nextLeftBrace;
      } else {
        nextStart = nextLeftBracket;
      }
    }
  }

  if (null === nextStart) {
    return null;
  } else {
    return findJson(content, nextStart);
  }
}
/**
 * Searches through the given content trying to skip over any non-JSON string
 * data to find JSON data.
 * 
 * Returns null if none found.
 * 
 * Otherwise, returns an object indicating the starting index for the found JSON,
 * the json content as an unparsed string, the non-json content trimmed from the
 * beginning, and the parsed JSON.
 */


function sliceJson(content) {
  if (!content || '' === content) return null;
  const result = findJson(content);

  if (null === result) {
    return null;
  } else {
    const {
      start,
      parsed
    } = result;
    return {
      start,
      json: content.slice(start),
      trimmed: content.slice(0, start),
      parsed
    };
  }
}

/* harmony default export */ __webpack_exports__["default"] = (sliceJson);

/***/ })

}]);
//# sourceMappingURL=4.js.map