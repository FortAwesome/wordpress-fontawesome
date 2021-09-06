(window["webpackJsonp_font_awesome_admin"] = window["webpackJsonp_font_awesome_admin"] || []).push([[8],{

/***/ "./node_modules/@fortawesome/fa-icon-chooser/dist/esm lazy recursive ^\\.\\/.*\\.entry\\.js.*$ include: \\.entry\\.js$ exclude: \\.system\\.entry\\.js$":
/*!************************************************************************************************************************************************************!*\
  !*** ./node_modules/@fortawesome/fa-icon-chooser/dist/esm lazy ^\.\/.*\.entry\.js.*$ include: \.entry\.js$ exclude: \.system\.entry\.js$ namespace object ***!
  \************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

var map = {
	"./fa-icon-chooser.entry.js": [
		"./node_modules/@fortawesome/fa-icon-chooser/dist/esm/fa-icon-chooser.entry.js",
		3,
		11
	],
	"./fa-icon.entry.js": [
		"./node_modules/@fortawesome/fa-icon-chooser/dist/esm/fa-icon.entry.js",
		3,
		12
	]
};
function webpackAsyncContext(req) {
	if(!__webpack_require__.o(map, req)) {
		return Promise.resolve().then(function() {
			var e = new Error("Cannot find module '" + req + "'");
			e.code = 'MODULE_NOT_FOUND';
			throw e;
		});
	}

	var ids = map[req], id = ids[0];
	return Promise.all(ids.slice(1).map(__webpack_require__.e)).then(function() {
		return __webpack_require__(id);
	});
}
webpackAsyncContext.keys = function webpackAsyncContextKeys() {
	return Object.keys(map);
};
webpackAsyncContext.id = "./node_modules/@fortawesome/fa-icon-chooser/dist/esm lazy recursive ^\\.\\/.*\\.entry\\.js.*$ include: \\.entry\\.js$ exclude: \\.system\\.entry\\.js$";
module.exports = webpackAsyncContext;

/***/ }),

/***/ "./src/chooser/IconChooserModal.js":
/*!*****************************************!*\
  !*** ./src/chooser/IconChooserModal.js ***!
  \*****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _fortawesome_fa_icon_chooser_react__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @fortawesome/fa-icon-chooser-react */ "./node_modules/@fortawesome/fa-icon-chooser-react/dist/index.js");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _createInterpolateElement__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! ../createInterpolateElement */ "./src/createInterpolateElement.js");






const IconChooserModal = props => {
  const {
    onSubmit,
    kitToken,
    version,
    pro,
    handleQuery,
    modalOpenEvent,
    getUrlText,
    settingsPageUrl
  } = props;
  const [isOpen, setOpen] = Object(react__WEBPACK_IMPORTED_MODULE_0__["useState"])(false);
  document.addEventListener(modalOpenEvent.type, () => setOpen(true));

  const closeModal = () => setOpen(false);

  const submitAndCloseModal = result => {
    if ('function' === typeof onSubmit) {
      onSubmit(result);
    }

    closeModal();
  };

  const isProCdn = !!pro && !kitToken;
  return /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(react__WEBPACK_IMPORTED_MODULE_0___default.a.Fragment, null, isOpen && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_1__["Modal"], {
    title: "Add a Font Awesome Icon",
    onRequestClose: closeModal
  }, isProCdn && /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("div", {
    style: {
      margin: '1em',
      backgroundColor: '#FFD200',
      padding: '1em',
      borderRadius: '.5em',
      fontSize: '15px'
    }
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Looking for Pro icons and styles? You’ll need to use a kit. ', 'font-awesome'), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
    href: settingsPageUrl
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Go to Font Awesome Plugin Settings', 'font-awesome'))), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_fortawesome_fa_icon_chooser_react__WEBPACK_IMPORTED_MODULE_2__["FaIconChooser"], {
    version: version,
    kitToken: kitToken,
    handleQuery: handleQuery,
    getUrlText: getUrlText,
    onFinish: result => submitAndCloseModal(result),
    searchInputPlaceholder: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Find icons by name, category, or keyword', 'font-awesome')
  }, /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "fatal-error-heading"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Well, this is awkward...', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "fatal-error-detail"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Something has gone horribly wrong. Check the console for additional error information.', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "start-view-heading"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])("Font Awesome is the web's most popular icon set, with tons of icons in a variety of styles.", 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "start-view-detail"
  }, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_4__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])("Not sure where to start? Here are some favorites, or try a search for <strong>spinners</strong>, <strong>shopping</strong>, <strong>food</strong>, or <strong>whatever you're looking for</strong>.", 'font-awesome'), {
    strong: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("strong", null)
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "search-field-label-free"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Search Font Awesome Free Icons in Version', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "search-field-label-pro"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Search Font Awesome Pro Icons in Version', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "searching-free"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])("You're searching Font Awesome Free icons in version", 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "searching-pro"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])("You're searching Font Awesome Pro icons in version", 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "light-requires-pro"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('You need to use a Pro kit to get Light icons.', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "thin-requires-pro"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('You need to use a Pro kit with Version 6 to get Thin icons.', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "duotone-requires-pro"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('You need to use a Pro kit with Version 5.10 or later to get Duotone icons.', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "uploaded-requires-pro"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('You need to use a Pro kit to get Uploaded icons.', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "kit-has-no-uploaded-icons"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('This kit contains no uploaded icons.', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "no-search-results-heading"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])("Sorry, we couldn't find anything for that.", 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "no-search-results-detail"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('You might try a different search...', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "suggest-icon-upload"
  }, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_4__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Or <a>upload your own icon</a> to a Pro kit!', 'font-awesome'), {
    // eslint-disable-next-line jsx-a11y/anchor-has-content
    a: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
      target: "_blank",
      rel: "noopener noreferrer",
      href: "https://fontawesome.com/v5.15/how-to-use/on-the-web/using-kits/uploading-icons"
    })
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "get-fontawesome-pro"
  }, Object(_createInterpolateElement__WEBPACK_IMPORTED_MODULE_4__["default"])(Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Or <a>use Font Awesome Pro</a> for more icons and styles!', 'font-awesome'), {
    // eslint-disable-next-line jsx-a11y/anchor-has-content
    a: /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("a", {
      target: "_blank",
      rel: "noopener noreferrer",
      href: "https://fontawesome.com/"
    })
  })), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "initial-loading-view-heading"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('Fetching icons', 'font-awesome')), /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement("span", {
    slot: "initial-loading-view-detail"
  }, Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_3__["__"])('When this thing gets up to 88 mph...', 'font-awesome')))));
};

/* harmony default export */ __webpack_exports__["default"] = (IconChooserModal);

/***/ }),

/***/ "./src/chooser/blockEditor.js":
/*!************************************!*\
  !*** ./src/chooser/blockEditor.js ***!
  \************************************/
/*! exports provided: setupBlockEditor */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setupBlockEditor", function() { return setupBlockEditor; });
/* harmony import */ var _IconChooserModal__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./IconChooserModal */ "./src/chooser/IconChooserModal.js");
/* harmony import */ var _shortcode__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./shortcode */ "./src/chooser/shortcode.js");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! @wordpress/element */ "@wordpress/element");
/* harmony import */ var _wordpress_element__WEBPACK_IMPORTED_MODULE_2___default = /*#__PURE__*/__webpack_require__.n(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__);
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! @wordpress/components */ "@wordpress/components");
/* harmony import */ var _wordpress_components__WEBPACK_IMPORTED_MODULE_3___default = /*#__PURE__*/__webpack_require__.n(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__);
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n");
/* harmony import */ var _wordpress_i18n__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__);
/* harmony import */ var _wordpress_rich_text__WEBPACK_IMPORTED_MODULE_5__ = __webpack_require__(/*! @wordpress/rich-text */ "@wordpress/rich-text");
/* harmony import */ var _wordpress_rich_text__WEBPACK_IMPORTED_MODULE_5___default = /*#__PURE__*/__webpack_require__.n(_wordpress_rich_text__WEBPACK_IMPORTED_MODULE_5__);
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__ = __webpack_require__(/*! @wordpress/block-editor */ "@wordpress/block-editor");
/* harmony import */ var _wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6___default = /*#__PURE__*/__webpack_require__.n(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__);







function setupBlockEditor(params) {
  // TODO: is this the right block type name for what we're doing here?
  const name = 'font-awesome/icon';

  const title = Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('Font Awesome Icon');

  const {
    modalOpenEvent,
    kitToken,
    version,
    pro,
    handleQuery,
    getUrlText,
    settingsPageUrl
  } = params;
  Object(_wordpress_rich_text__WEBPACK_IMPORTED_MODULE_5__["registerFormatType"])(name, {
    name,
    title: Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('Font Awesome Icon'),
    keywords: [Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('icon'), Object(_wordpress_i18n__WEBPACK_IMPORTED_MODULE_4__["__"])('font awesome')],
    tagName: 'i',
    className: null,
    // if object is true, then the HTML rendered for this type will lack a closing tag.
    object: false,
    edit: class FontAwesomeIconEdit extends _wordpress_element__WEBPACK_IMPORTED_MODULE_2__["Component"] {
      constructor(props) {
        super(...arguments);
        this.handleFormatButtonClick = this.handleFormatButtonClick.bind(this);
        this.handleSelect = this.handleSelect.bind(this);
      }

      handleFormatButtonClick() {
        document.dispatchEvent(modalOpenEvent);
      }

      handleSelect(event) {
        const {
          value,
          onChange
        } = this.props; // TODO: this would indicate an invalid event. Do we want some error handling here?

        if (!event.detail) return;
        const shortcode = Object(_shortcode__WEBPACK_IMPORTED_MODULE_1__["buildShortCodeFromIconChooserResult"])(event.detail);
        onChange(Object(_wordpress_rich_text__WEBPACK_IMPORTED_MODULE_5__["insert"])(value, shortcode));
      }

      render() {
        return /*#__PURE__*/React.createElement(_wordpress_element__WEBPACK_IMPORTED_MODULE_2__["Fragment"], null, /*#__PURE__*/React.createElement(_wordpress_block_editor__WEBPACK_IMPORTED_MODULE_6__["RichTextToolbarButton"], {
          icon: /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__["SVG"], {
            xmlns: "http://www.w3.org/2000/svg",
            viewBox: "0 0 448 512",
            className: "svg-inline--fa fa-font-awesome fa-w-14"
          }, /*#__PURE__*/React.createElement(_wordpress_components__WEBPACK_IMPORTED_MODULE_3__["Path"], {
            fill: "currentColor",
            d: "M397.8 32H50.2C22.7 32 0 54.7 0 82.2v347.6C0 457.3 22.7 480 50.2 480h347.6c27.5 0 50.2-22.7 50.2-50.2V82.2c0-27.5-22.7-50.2-50.2-50.2zm-45.4 284.3c0 4.2-3.6 6-7.8 7.8-16.7 7.2-34.6 13.7-53.8 13.7-26.9 0-39.4-16.7-71.7-16.7-23.3 0-47.8 8.4-67.5 17.3-1.2.6-2.4.6-3.6 1.2V385c0 1.8 0 3.6-.6 4.8v1.2c-2.4 8.4-10.2 14.3-19.1 14.3-11.3 0-20.3-9-20.3-20.3V166.4c-7.8-6-13.1-15.5-13.1-26.3 0-18.5 14.9-33.5 33.5-33.5 18.5 0 33.5 14.9 33.5 33.5 0 10.8-4.8 20.3-13.1 26.3v18.5c1.8-.6 3.6-1.2 5.4-2.4 18.5-7.8 40.6-14.3 61.5-14.3 22.7 0 40.6 6 60.9 13.7 4.2 1.8 8.4 2.4 13.1 2.4 22.7 0 47.8-16.1 53.8-16.1 4.8 0 9 3.6 9 7.8v140.3z"
          })),
          title: title,
          onClick: this.handleFormatButtonClick
        }), /*#__PURE__*/React.createElement(_IconChooserModal__WEBPACK_IMPORTED_MODULE_0__["default"], {
          modalOpenEvent: modalOpenEvent,
          kitToken: kitToken,
          version: version,
          pro: pro,
          settingsPageUrl: settingsPageUrl,
          handleQuery: handleQuery,
          onSubmit: this.handleSelect,
          getUrlText: getUrlText
        }));
      }

    }
  });
}

/***/ }),

/***/ "./src/chooser/classicEditor.js":
/*!**************************************!*\
  !*** ./src/chooser/classicEditor.js ***!
  \**************************************/
/*! exports provided: handleSubmit, setupClassicEditor */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "handleSubmit", function() { return handleSubmit; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setupClassicEditor", function() { return setupClassicEditor; });
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! react */ "react");
/* harmony import */ var react__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(react__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! react-dom */ "react-dom");
/* harmony import */ var react_dom__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(react_dom__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _IconChooserModal__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./IconChooserModal */ "./src/chooser/IconChooserModal.js");
/* harmony import */ var _shortcode__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ./shortcode */ "./src/chooser/shortcode.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_4__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_4___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_4__);





function handleSubmit(event) {
  const insert = lodash_get__WEBPACK_IMPORTED_MODULE_4___default()(window, 'wp.media.editor.insert');
  insert && insert(Object(_shortcode__WEBPACK_IMPORTED_MODULE_3__["buildShortCodeFromIconChooserResult"])(event.detail));
}
function setupClassicEditor(params) {
  const {
    iconChooserContainerId,
    modalOpenEvent,
    kitToken,
    version,
    pro,
    handleQuery,
    getUrlText,
    settingsPageUrl
  } = params;
  const container = document.querySelector(`#${iconChooserContainerId}`);
  if (!container) return;
  if (!window.tinymce) return;
  let wpComponentsStyleAdded = false;

  if (!wpComponentsStyleAdded) {
    wpComponentsStyleAdded = true;
    __webpack_require__.e(/*! import() */ 10).then(__webpack_require__.bind(null, /*! @wordpress/components/build-style/style.css */ "./node_modules/@wordpress/components/build-style/style.css")).then(() => {}).catch(err => console.error('Font Awesome Plugin failed to load styles for the Icon Chooser in the Classic Editor', err));
  } // TODO: consider how to add Font Awesome to the Tiny MCE visual pane.
  // But there maybe unexpected behaviors.

  /*
  const editor = tinymce.activeEditor
   editor.on('init', e => {
    const script = editor.dom.doc.createElement('script')
    script.setAttribute('src', 'https://kit.fontawesome.com/fakekit.js')
    script.setAttribute('crossorigin', 'anonymous')
    editor.dom.doc.head.appendChild(script)
  })
  */


  react_dom__WEBPACK_IMPORTED_MODULE_1___default.a.render( /*#__PURE__*/react__WEBPACK_IMPORTED_MODULE_0___default.a.createElement(_IconChooserModal__WEBPACK_IMPORTED_MODULE_2__["default"], {
    kitToken: kitToken,
    version: version,
    pro: pro,
    modalOpenEvent: modalOpenEvent,
    handleQuery: handleQuery,
    settingsPageUrl: settingsPageUrl,
    onSubmit: handleSubmit,
    getUrlText: getUrlText
  }), container);
}

/***/ }),

/***/ "./src/chooser/index.js":
/*!******************************!*\
  !*** ./src/chooser/index.js ***!
  \******************************/
/*! exports provided: setupIconChooser */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "setupIconChooser", function() { return setupIconChooser; });
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var _blockEditor__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./blockEditor */ "./src/chooser/blockEditor.js");
/* harmony import */ var _classicEditor__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./classicEditor */ "./src/chooser/classicEditor.js");



let classicEditorSetupComplete = false;

function setupClassicEditorIconChooser(initialParams) {
  // We only want to do this once.
  if (classicEditorSetupComplete) return;
  if (!window.tinymce) return;
  const params = { ...initialParams,
    iconChooserContainerId: 'font-awesome-icon-chooser-container',
    iconChooserMediaButtonClass: 'font-awesome-icon-chooser-media-button'
  };
  Object(_classicEditor__WEBPACK_IMPORTED_MODULE_2__["setupClassicEditor"])(params);
  classicEditorSetupComplete = true;
}

function setupIconChooser(initialParams) {
  const params = { ...initialParams,
    modalOpenEvent: new Event('fontAwesomeIconChooserOpen', {
      "bubbles": true,
      "cancelable": false
    })
  };

  window['__FontAwesomeOfficialPlugin__openIconChooserModal'] = () => {
    document.dispatchEvent(params.modalOpenEvent);
  };

  if (!!lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(initialParams, 'isGutenbergPage')) {
    Object(_blockEditor__WEBPACK_IMPORTED_MODULE_1__["setupBlockEditor"])(params);
  }
  /**
   * Tiny MCE loading time: In WordPress 5, it's straightforward to enqueue
   * this script with a script dependency of wp-tinymce. But that's not available
   * in WP 4, and there doesn't seem to be any way to ensure that the Tiny MCE
   * script has been loaded before this, other than to add a script after the
   * Tiny MCE scripts have been printed.
   *
   * So what we'll do instead is simply export this function that can be exposed
   * as a global function, and in our back end PHP code, we'll add an inline script
   * to invoke that global for tinyMCE setup if and when it is necessary.
   */


  return {
    setupClassicEditorIconChooser: () => setupClassicEditorIconChooser(params)
  };
}

/***/ }),

/***/ "./src/chooser/shortcode.js":
/*!**********************************!*\
  !*** ./src/chooser/shortcode.js ***!
  \**********************************/
/*! exports provided: buildShortCodeFromIconChooserResult */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "buildShortCodeFromIconChooserResult", function() { return buildShortCodeFromIconChooserResult; });
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! lodash/get */ "./node_modules/lodash/get.js");
/* harmony import */ var lodash_get__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(lodash_get__WEBPACK_IMPORTED_MODULE_0__);

function buildShortCodeFromIconChooserResult(result) {
  const attrs = [];

  if (!result.iconName) {
    // TODO: decide how/whether to handle this error condition
    console.error('Font Awesome Icon Chooser: missing required iconName attribute for shortcode');
    return;
  }

  attrs.push(`name="${result.iconName}"`);
  const optionalAttrs = ['prefix', 'style', 'class', 'aria-hidden', 'aria-label', 'aria-labelledby', 'title', 'role'];

  for (const attr of optionalAttrs) {
    const val = lodash_get__WEBPACK_IMPORTED_MODULE_0___default()(result, attr);

    if (val) {
      attrs.push(`${attr}="${val}"`);
    }
  }

  return `[icon ${attrs.join(' ')}]`;
}

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

/***/ })

}]);
//# sourceMappingURL=8.js.map