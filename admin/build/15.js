(window["webpackJsonp_font_awesome_admin"] = window["webpackJsonp_font_awesome_admin"] || []).push([[15],{

/***/ "./src/chooser/handleQuery.js":
/*!************************************!*\
  !*** ./src/chooser/handleQuery.js ***!
  \************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @wordpress/api-fetch */ "@wordpress/api-fetch");
/* harmony import */ var _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0__);


const configureQueryHandler = params => async query => {
  try {
    const {
      apiNonce,
      rootUrl,
      restApiNamespace
    } = params; // If apiFetch is from wp.apiFetch, it may already have RootURLMiddleware set up.
    // If we're using the fallback (i.e. when running in the Classic Editor), then
    // it doesn't yet have thr RootURLMiddleware.
    // We want to guarantee that it's there, so we'll always add it.
    // So what if it was already there? Experiment seems to have shown that this
    // is idempotent. It doesn't seem to hurt to just do it again, so we will.

    _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default.a.use(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default.a.createRootURLMiddleware(rootUrl)); // We need the nonce to be set up because we're going to run our query through
    // the API controller end point, which requires non-public authorization.

    _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default.a.use(_wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default.a.createNonceMiddleware(apiNonce));
    return await _wordpress_api_fetch__WEBPACK_IMPORTED_MODULE_0___default()({
      path: `${restApiNamespace}/api`,
      method: 'POST',
      body: query
    });
  } catch (error) {
    console.error('CAUGHT:', error);
    throw new Error(error);
  }
};

/* harmony default export */ __webpack_exports__["default"] = (configureQueryHandler);

/***/ })

}]);
//# sourceMappingURL=15.js.map