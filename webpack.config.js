const path = require('path')
const webpack = require('webpack')

module.exports = {
  entry: {
    index: './public/javascripts/entrypoints/index.js',
    home: './public/javascripts/entrypoints/home.js',
  },
  output: {
    path: path.resolve(__dirname, 'dist', 'dependencies'),
    filename: '[name].js',
  },
  module: {
    rules: [
      {
        test: /\.scss$/,
        use: [
          'style-loader', // creates style nodes from JS strings
          'css-loader', // translates CSS into CommonJS
          'sass-loader', // compiles Sass to CSS
        ],
      },
      {
        test: /\.(woff|woff2|eot|ttf|otf)$/,
        use: [
          'file-loader',
        ],
      },
    ],
  },
  plugins: [
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
    }),
  ],
}
