//inclui gulp
var gulp = require('gulp');

//inclui plugins
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sass = require('gulp-ruby-sass');

//concatenar, renomear e minificar arquivos js
gulp.task('scripts', function() {
  return gulp.src('view/js/*js')
    .pipe(concat('main.js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest('view/js/build'));
});

//compilar sass, minificar e renomear
gulp.task('sass', function() {
  return sass('view/scss/*.scss', {style: 'compressed'})
    .pipe(rename({suffix: '.min'}))
    .pipe(gulp.dest('view/css/build'));
});

//rastrear mudanças
gulp.task('watch', function() {
  //rastrear arquivos .js
  gulp.watch('view/js/*.js', ['scripts']);
  //rastrear arquivos .scss
  gulp.watch('view/scss/*.scss', ['sass']);
});

//Default
gulp.task('default', [/*'scripts', 'sass',*/ 'watch']);
