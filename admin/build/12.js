(window["webpackJsonp_font_awesome_admin"] = window["webpackJsonp_font_awesome_admin"] || []).push([[12],{

/***/ "./node_modules/@fortawesome/fa-icon-chooser/dist/esm/fa-icon.entry.js":
/*!*****************************************************************************!*\
  !*** ./node_modules/@fortawesome/fa-icon-chooser/dist/esm/fa-icon.entry.js ***!
  \*****************************************************************************/
/*! exports provided: fa_icon */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "fa_icon", function() { return FaIcon; });
/* harmony import */ var _index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./index-4ad4b058.js */ "./node_modules/@fortawesome/fa-icon-chooser/dist/esm/index-4ad4b058.js");
/* harmony import */ var _utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./utils-dd78e4a8.js */ "./node_modules/@fortawesome/fa-icon-chooser/dist/esm/utils-dd78e4a8.js");


const faIconCss = "";
const FaIcon = class {
  constructor(hostRef) {
    Object(_index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__["r"])(this, hostRef);
    this.pro = false;
    this.loading = false;
  }

  componentWillLoad() {
    if (this.iconUpload) {
      this.iconDefinition = {
        prefix: 'fak',
        iconName: this.iconUpload.name,
        icon: [parseInt(`${this.iconUpload.width}`), parseInt(`${this.iconUpload.height}`), [], this.iconUpload.unicode.toString(16), this.iconUpload.path]
      };
      return;
    }

    if (this.icon) {
      this.iconDefinition = this.icon;
      return;
    }

    if (!this.svgApi) {
      console.error(`${_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["C"]}: fa-icon: svgApi prop is needed but is missing`, this);
      return;
    }

    if (!(this.stylePrefix && this.name)) {
      console.error(`${_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["C"]}: fa-icon: the 'stylePrefix' and 'name' props are needed to render this icon but not provided.`, this);
      return;
    }

    const {
      findIconDefinition
    } = this.svgApi;
    const iconDefinition = findIconDefinition && findIconDefinition({
      prefix: this.stylePrefix,
      iconName: this.name
    });

    if (iconDefinition) {
      this.iconDefinition = iconDefinition;
      return;
    }

    if (!this.pro) {
      console.error(`${_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["C"]}: fa-icon: 'pro' prop is false but no free icon is avaialble`, this);
      return;
    }

    if (!this.svgFetchBaseUrl) {
      console.error(`${_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["C"]}: fa-icon: 'svgFetchBaseUrl' prop is absent but is necessary for fetching icon`, this);
      return;
    }

    if (!this.kitToken) {
      console.error(`${_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["C"]}: fa-icon: 'kitToken' prop is absent but is necessary for accessing icon`, this);
      return;
    }

    this.loading = true;
    const iconUrl = `${this.svgFetchBaseUrl}/${_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["P"][this.stylePrefix]}/${this.name}.svg?token=${this.kitToken}`;
    const library = _utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["l"].get(this, 'svgApi.library');

    if ('function' !== typeof this.getUrlText) {
      console.error(`${_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["C"]}: fa-icon: 'getUrlText' prop is absent but is necessary for fetching icon`, this);
      return;
    }

    this.getUrlText(iconUrl).then(svg => {
      const iconDefinition = {
        iconName: this.name,
        prefix: this.stylePrefix,
        icon: Object(_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["p"])(svg)
      };
      library && library.add(iconDefinition);
      this.iconDefinition = Object.assign({}, iconDefinition);
    }).catch(e => {
      console.error(`${_utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["C"]}: fa-icon: failed when using 'getUrlText' to fetch icon`, e, this);
    }).finally(() => {
      this.loading = false;
    });
  }

  buildSvg(iconDefinition, extraClasses) {
    if (!iconDefinition) return;
    const [width, height,,, svgPathData] = _utils_dd78e4a8_js__WEBPACK_IMPORTED_MODULE_1__["l"].get(iconDefinition, 'icon', []);
    const classes = ['svg-inline--fa'];

    if (this.class) {
      classes.push(this.class);
    }

    if (extraClasses) {
      classes.push(extraClasses);
    }

    if (this.size) {
      classes.push(`fa-${this.size}`);
    }

    const allClasses = classes.join(' ');

    if (Array.isArray(svgPathData)) {
      return Object(_index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__["h"])("svg", {
        class: allClasses,
        xmlns: "http://www.w3.org/2000/svg",
        viewBox: `0 0 ${width} ${height}`
      }, Object(_index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__["h"])("path", {
        fill: "currentColor",
        class: "fa-primary",
        d: svgPathData[0]
      }), Object(_index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__["h"])("path", {
        fill: "currentColor",
        class: "fa-secondary",
        d: svgPathData[1]
      }));
    } else {
      return Object(_index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__["h"])("svg", {
        class: allClasses,
        xmlns: "http://www.w3.org/2000/svg",
        viewBox: `0 0 ${width} ${height}`
      }, Object(_index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__["h"])("path", {
        fill: "currentColor",
        d: svgPathData
      }));
    }
  }

  render() {
    return this.iconDefinition ? this.buildSvg(this.iconDefinition) : Object(_index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__["h"])(_index_4ad4b058_js__WEBPACK_IMPORTED_MODULE_0__["f"], null);
  }

};
FaIcon.style = faIconCss;


/***/ })

}]);
//# sourceMappingURL=12.js.map