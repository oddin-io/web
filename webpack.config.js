const path = require('path')
// const webpack = require('webpack')

module.exports = {
  entry: {
    index: './public/javascripts/entrypoints/index.js',
    home: './public/javascripts/entrypoints/home.js',
  },
  output: {
    path: path.resolve(__dirname, 'public/dist'),
    filename: '[name].js',
  },
  resolve: {
    alias: {
      angular: 'angular/angular.min.js',
    },
  },
  plugins: [

  ],
}
