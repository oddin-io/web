const compressor = require('node-minify')

compressor.minify({
  compressor: 'uglifyjs',
  input: 'public/javascripts/**/*.js',
  output: 'public/build/oddin-build.min.js',
  callback: function(err, min) {
    console.log('wildcards Uglifyjs');
    console.log(err);
    //console.log(min);
  }
});
