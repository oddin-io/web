var gulp = require('gulp')
var concat = require('gulp-concat')
var uglify = require('gulp-uglify')
var rename = require('gulp-rename')
var sass = require('gulp-ruby-sass')

// concatenar, renomear e minificar arquivos js
gulp.task('scripts', function () {
  return gulp.src('./public/js/*js')
    .pipe(concat('main.js'))
    .pipe(rename({ suffix: '.min' }))
    .pipe(uglify())
    .pipe(gulp.dest('./public/js/build'))
})

// compilar sass, minificar e renomear
gulp.task('sass-min', ['sass'], function () {
  return sass('./public/scss/*.scss', { style: 'compressed' })
    .pipe(rename({ suffix: '.min' }))
    .pipe(gulp.dest('./public/css'))
})

gulp.task('sass', function () {
  return sass('./public/scss/*.scss')
    .pipe(gulp.dest('./public/css'))
})

// rastrear mudanças
gulp.task('watch', function () {
  // rastrear arquivos .js
  gulp.watch('./public/js/*.js', ['scripts'])
  // rastrear arquivos .scss
  gulp.watch('./public/scss/*.scss', ['sass-min'])
})

// Default
gulp.task('default', ['watch'])

gulp.task('build', ['scripts', 'sass-min'])
