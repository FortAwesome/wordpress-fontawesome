(window["webpackJsonp_font_awesome_admin"] = window["webpackJsonp_font_awesome_admin"] || []).push([[14],{

/***/ "./src/chooser/getUrlText.js":
/*!***********************************!*\
  !*** ./src/chooser/getUrlText.js ***!
  \***********************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_0__);

const ERROR_MSG = 'Font Awesome plugin unexpected response for Icon Chooser';

const getUrlText = url => {
  return axios__WEBPACK_IMPORTED_MODULE_0___default.a.get(url).then(response => {
    if (response.status >= 200 || response.satus <= 299) {
      return response.data;
    } else {
      console.error(response);
      return Promise.reject(ERROR_MSG);
    }
  }).catch(e => {
    console.error(e);
    return Promise.reject(e);
  });
};

/* harmony default export */ __webpack_exports__["default"] = (getUrlText);

/***/ })

}]);
//# sourceMappingURL=14.js.map