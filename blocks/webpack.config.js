module.exports = {
  entry: {
    block: './font-awesome/index.js'
  },
	output: {
		path: __dirname,
		filename: './[name].build.js',
  },
  externals: {
    react: 'React'
  },
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
