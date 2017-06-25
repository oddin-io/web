const compressor = require('node-minify')

compressor.minify({
  compressor: 'uglifyjs',
  input: 'public/javascripts/**/*.js',
  output: 'public/build/oddin-home-build.min.js',
  callback: function (err) {
    if (err) {
      console.log(err)
      return
    }
    console.log('- home-build-js minified')
  },
})

compressor.minify({
  compressor: 'uglifyjs',
  input: ['public/javascripts/angular/app.js',
    'public/javascripts/angular/config.js',
    'public/javascripts/angular/controllers/LoginController.js',
    'public/javascripts/angular/services/LoginAPI.js',
    'public/javascripts/angular/directives/oddinPreloader.js'],
  output: 'public/build/oddin-index-build.min.js',
  callback: function (err) {
    if (err) {
      console.log(err)
      return
    }
    console.log('- index-build-js minified')
  },
})

compressor.minify({
  compressor: 'clean-css',
  input: ['public/stylesheets/material-icons.css',
    'public/stylesheets/materialize_custom.css',
    'public/stylesheets/login_style.css',
  ],
  output: 'public/build/oddin-index-build.min.css',
  callback: function (err) {
    if (err) {
      console.log(err)
      return
    }
    console.log('- index-build-css minified')
  },
})

compressor.minify({
  compressor: 'clean-css',
  input: ['public/stylesheets/material-icons.css',
    'public/stylesheets/materialize_custom.css',
    'public/stylesheets/user_style.css',
  ],
  output: 'public/build/oddin-home-build.min.css',
  callback: function (err) {
    if (err) {
      console.log(err)
      return
    }
    console.log('- home-build-css minified')
  },
})
