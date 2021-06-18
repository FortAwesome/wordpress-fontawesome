const webpack = require('webpack');

module.exports = {
  entry: {
    block: './font-awesome/index.js'
  },
	output: {
		path: __dirname,
    filename: './editor-support.js',
  },
  externals: {
    react: 'React'
  },
  plugins: [
    // For now, we just want a single static JS bundle that can be enqueued via
    // wp_enqueue_script.
    new webpack.optimize.LimitChunkCountPlugin({
      maxChunks: 1,
    }),
  ],
	module: {
    rules: [
      {
        test: /\.m?js$/,
        exclude: /(node_modules|bower_components)/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: ['@babel/preset-env']
          }
        }
      }
    ]
  },
};
