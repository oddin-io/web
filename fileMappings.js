const path = require('path')

const distDir = path.resolve(__dirname, 'dist')
const entrypointsDir = path.resolve(__dirname, 'public', 'javascripts', 'entrypoints')

module.exports = {
  distDir: distDir,
  views: 'views/**/*.pug',
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
