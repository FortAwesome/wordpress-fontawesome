const defaultConfig = require( '@wordpress/scripts/config/webpack.config' )
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin
const get = require('lodash/get')

module.exports = {
  ...defaultConfig,
  plugins: [
    ...defaultConfig.plugins,
    new BundleAnalyzerPlugin({ analyzerMode: 'static', reportFilename: '../webpack-stats.html', openAnalyzer: false })
  ],
  output: {
    filename: 'compat.js',
    path: __dirname + '/build'
  },
  optimization: {
    splitChunks: {
      cacheGroups: {
        default: false
      }
    },
    runtimeChunk: false
  },
  module: {
    ...defaultConfig.module,
    /**
     * lodash.js is where the window._ global is set. It's possible that any
     * package we depend upon might be importing lodash in a way that results
     * in that global being set, which we don't want.
     *
     * For example, we depend upon @wordpress/api-fetch, which gets loaded in via
     * webpack automatically as a separate chunk when needed for WordPress 4
     * compatibility. It depends on @wordpress/url, which in clean-for-slug.js
     * does this:
     *
     * import { deburr, trim } from 'lodash';
     *
     * This kind of import pulls in lodash.js, which sets that global.
     *
     * This seems to be happening in more than one place. It's kind of a nuclear
     * option to let this babel-load rule run over everything under node_modules,
     * but that's where the culprits are. The build could be sped up significantly
     * if there were smarter way to do this.
     *
     * One place to see whether this is working is:
     * On WordPress 4, create a new post. Check for _.VERSION in the JavaScript
     * console. It should be something like 1.8.3, and not 4.whatever. Furthermore,
     * there should be no other errors in the console. And then, you should be
     * able to click the "Add Font Awesome" media button and see the icon chooser
     * load normally. If all of that works, then we're good--or so it seems...
     */
    rules: [
      ...(get(defaultConfig, 'module.rules', [])),
      {
        test: /\.m?js$/,
        //exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-react'],
            plugins: ['babel-plugin-lodash']
          }
        }
      }
    ],
  }
}
