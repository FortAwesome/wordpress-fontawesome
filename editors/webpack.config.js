const webpack = require('webpack');

module.exports = {
  entry: {
    block: './block/js/index.js',
    tinymce: './tinymce/js/index.js'
  },
	output: {
		path: __dirname,
    filename: './build/editor-support.[name].js',
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
      },
      {
        test: /\.css$/i,
        use: ["css-loader"]
      }
    ]
  },
};
