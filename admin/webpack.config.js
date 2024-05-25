const defaultConfig = require("@wordpress/scripts/config/webpack.config");
const get = require("lodash/get");

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

module.exports = {
  ...defaultConfig,
  output: {
    ...defaultConfig.output,
    chunkFilename: "[name]-[chunkhash].js",
  }
};
