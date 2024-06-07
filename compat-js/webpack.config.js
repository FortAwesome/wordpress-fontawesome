const defaultConfig = require('@wordpress/scripts/config/webpack.config')
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin
const get = require('lodash/get')
const webpack = require('webpack')
const rimraf = require('rimraf')

module.exports = {
  ...defaultConfig,
  plugins: [
    ...defaultConfig.plugins,
    new BundleAnalyzerPlugin({ analyzerMode: 'static', reportFilename: '../webpack-stats.html', openAnalyzer: false }),
    new webpack.ProvidePlugin({ process: 'process/browser' }),
    new (class {
      apply(compiler) {
        compiler.hooks.done.tap('Remove LICENSE', () => {
          console.log('Remove LICENSE.txt')
          rimraf.sync('./build/*.LICENSE.txt', { glob: true })
        });
      }
    })()
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
  }
}
