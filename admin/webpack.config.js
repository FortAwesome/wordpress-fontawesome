const defaultConfig = require( '@wordpress/scripts/config/webpack.config' )
const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin
const get = require('lodash/get')

module.exports = {
  ...defaultConfig,
  plugins: [
    ...defaultConfig.plugins,
    new BundleAnalyzerPlugin({ analyzerMode: 'static', reportFilename: '../webpack-stats.html', openAnalyzer: false })
  ],
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
            plugins: ['babel-plugin-lodash'],
            // env: {
            //   development: {
            //     // This just makes babel a bit more quiet in development.
            //     compact: false
            //   }
            // }
          }
        }
      }      
    ],
  },
  externals: [
    /**
     * The idea here is that we want packages like react, react-dom,
     * and @wordpress/element to remain as externals to all of our own app's
     * chunks, and external to all our dependencies that rely on them.
     *
     * However, we have a compat.js output that we're building too. And in *that*
     * bundle, we don't want these things to remain external--that's where we
     * actually need to bundle them.
     * 
     * Now, whether we're in WordPress 5 or WordPress 4, all of our externals
     * are going to be based not on the usual globals like window.React, because
     * of the possibility of colliding with other plugins or themes that may
     * modify those globals, but on our own globals under __Font_Awesome_Webpack_Externals__.
     *
     * Our app's index.js should initialize that __Font_Awesome_Webpack_Externals__
     * early, before loading any modules that may depend on those externals.
     *
     * Under WordPress 5, the wp_enqueue_script of the main admin JS bundle should
     * declare the appropriate depenedencies, like wp-element. Then our app's
     * index.js should just set up those __Font_Awesome_Webpack_Externals__
     * globals as copies of the modules that would be available as part of
     * WordPress core, like window.wp.element.
     *
     * If we're running under WordPress 4, then we should be enqueueing compat.js,
     * which would load a JavaScript bundle with all of the stuff that would normally
     * be there for us in WordPress 5. It should set up that __Font_Awesome_Webpack_Externals__
     * global accordingly.
     *
     * So either way, whether we're running under WordPress 4 or 5, that global
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
    function (context, request, callback) {
      switch(request) {
        case 'react':
          return callback(null, 'root __Font_Awesome_Webpack_Externals__.React')
        case 'react-dom':
          return callback(null, 'root __Font_Awesome_Webpack_Externals__.ReactDOM')
        case '@wordpress/i18n':
          return callback(null, 'root __Font_Awesome_Webpack_Externals__.i18n')
        case '@wordpress/api-fetch':
          return callback(null, 'root __Font_Awesome_Webpack_Externals__.apiFetch')
        case '@wordpress/components':
          return callback(null, 'root __Font_Awesome_Webpack_Externals__.components')
        case '@wordpress/element':
          return callback(null, 'root __Font_Awesome_Webpack_Externals__.element')
        case '@wordpress/rich-text':
          return callback(null, 'root __Font_Awesome_Webpack_Externals__.richText')
        case '@wordpress/block-editor':
          return callback(null, 'root __Font_Awesome_Webpack_Externals__.blockEditor')
        default:
          return callback()
      }
    }
  ]
}
