const rewire = require('rewire')
const defaults = rewire('react-scripts/scripts/build.js')
let config = defaults.__get__('config')

const WebpackDynamicPublicPathPlugin = require("webpack-dynamic-public-path")

/*
config.optimization.splitChunks = {
	cacheGroups: {
		default: false
	}
}

config.optimization.runtimeChunk = false

*/
config.output.publicPath = '__Font_Awesome_Plugin_Webpack_Public_Path_Placeholder__'

config.plugins.push(
    new WebpackDynamicPublicPathPlugin({
        externalPublicPath: 'window.__FontAwesomeOfficialPlugin__.webpackPublicPath'
    })
)
