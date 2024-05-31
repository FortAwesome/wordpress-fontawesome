const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const get = require("lodash/get");
const { basename, dirname } = require("path");

/**
 * There have apparently been problems with webpack chunk loading and caches.
 * So we should add hashes to the chunk file names.
 * See: https://wordpress.org/support/topic/plugin-settings-page-is-empty-2/#post-14855904
 */
const miniCssExtractPlugin = defaultConfig.plugins.find((p) =>
  "MiniCssExtractPlugin" === p.constructor.name
);
miniCssExtractPlugin.options.filename = "[name]-[contenthash].css";
miniCssExtractPlugin.options.chunkFilename = "[name]-[chunkhash].css";

// After updating to @wordpress/scripts wp-6.5, when using --webpack-no-externals
// there was an error:
//
// TypeError [ERR_INVALID_ARG_TYPE]: The "path" argument must be of type string. Received null
//
// It would occur in the config/webpack.config.js bundled in @wordpress/scripts
// when chunks[ 0 ].name was not a string. (It would be null)
//
// This is a way of overriding that so that an empty string is used instead of null
// in that case.
//
// The only asset that seems to be impacted by it is the stylesheet that is loaded
// when the Icon Chooser is launched in the block editor. For example:
//
// style--e8e63b0dec48060a8adc.css
//
// If there were a non-null name, say "foo", then this asset would be called:
//
// style-foo-e8e63b0dec48060a8adc.css
//
// Using the empty string here instead of null seems to result in that asset still
// loading as expected and styling everything as expected.
defaultConfig.optimization.splitChunks.cacheGroups.style.name = (
  _,
  chunks,
  cacheGroupKey,
) => {
  const chunkName = chunks[0].name || "";
  return `${
    dirname(
      chunkName,
    )
  }/${cacheGroupKey}-${basename(chunkName)}`;
};

// This causes the JavaScript chunks to include the chunk hash in the filename,
// which is important for cache busting purposes.
defaultConfig.output.chunkFilename = "[name]-[chunkhash].js";

defaultConfig.externals = [
  /**
   * The idea here is that we want packages like react, react-dom,
   * and @wordpress/element to remain as externals to all of our own app's
   * chunks, and external to all our dependencies that rely on them.
   *
   * However, we have a compat.js output that we're building too. And in *that*
   * bundle, we don't want these things to remain external--that's where we
   * actually need to bundle them.
   *
   * Now, whether we're in WordPress 4, 5, or 6, all of our externals
   * are going to be based not on the usual globals like window.React, because
   * of the possibility of colliding with other plugins or themes that may
   * modify those globals, but on our own globals under __Font_Awesome_Webpack_Externals__.
   *
   * Our app's index.js should initialize that __Font_Awesome_Webpack_Externals__
   * early, before loading any modules that may depend on those externals.
   *
   * Under WordPress >=5, the wp_enqueue_script of the main admin JS bundle should
   * declare the appropriate dependencies, like wp-element. Then our app's
   * index.js should just set up those __Font_Awesome_Webpack_Externals__
   * globals as copies of the modules that would be available as part of
   * WordPress core, like window.wp.element.
   *
   * If we're running under WordPress 4, then we should be enqueueing compat.js,
   * which would load a JavaScript bundle with all of the stuff that would normally
   * be there for us in WordPress 5. It should set up that __Font_Awesome_Webpack_Externals__
   * global accordingly.
   *
   * So in any case, whether we're running under WordPress 4, 5, or 6, that global
   * will be set up with the appropriate externals.
   *
   * Then in our app's modules--as long as they are loaded after those globals
   * are set up--we can just do things like:
   *
   * import React from 'react'
   *
   * or
   *
   * import { __ } from '@wordpress/i18n'
   *
   * ...and webpack will replace those imports with the right assignments
   * from that global.
   */
  function ({ context, request }, callback) {
    switch (request) {
      case "react":
        return callback(null, "root __Font_Awesome_Webpack_Externals__.React");
      case "react-dom":
        return callback(
          null,
          "root __Font_Awesome_Webpack_Externals__.ReactDOM",
        );
      case "@wordpress/i18n":
        return callback(null, "root __Font_Awesome_Webpack_Externals__.i18n");
      case "@wordpress/api-fetch":
        return callback(
          null,
          "root __Font_Awesome_Webpack_Externals__.apiFetch",
        );
      case "@wordpress/components":
        return callback(
          null,
          "root __Font_Awesome_Webpack_Externals__.components",
        );
      case "@wordpress/element":
        return callback(
          null,
          "root __Font_Awesome_Webpack_Externals__.element",
        );
      case "@wordpress/rich-text":
        return callback(
          null,
          "root __Font_Awesome_Webpack_Externals__.richText",
        );
      case "@wordpress/block-editor":
        return callback(
          null,
          "root __Font_Awesome_Webpack_Externals__.blockEditor",
        );
      case "@wordpress/dom-ready":
        return callback(
          null,
          "root __Font_Awesome_Webpack_Externals__.domReady",
        );
      default:
        return callback();
    }
  },
];

module.exports = defaultConfig;
