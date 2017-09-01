const path = require('path')

const distDir = path.resolve(__dirname, 'dist')
const entrypointsDir = path.resolve(__dirname, 'public', 'entrypoints')

module.exports = {
  distDir: distDir,
  vendorDir: path.resolve(__dirname, 'public', 'vendor'),
  views: 'views/**/*.pug',
  styles: 'public/entrypoints/**/*.sass',
  webpack: {
    entry: {
      index: path.join(entrypointsDir, 'index.js'),
      home: path.join(entrypointsDir, 'home.js'),
    },
    output: {
      path: distDir,
      filename: '[name].js',
    },
  },
}
