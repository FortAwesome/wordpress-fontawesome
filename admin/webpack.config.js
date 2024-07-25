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

module.exports = defaultConfig;
