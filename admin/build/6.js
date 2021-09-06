(window["webpackJsonp_font_awesome_admin"] = window["webpackJsonp_font_awesome_admin"] || []).push([[6],{

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
//# sourceMappingURL=6.js.map