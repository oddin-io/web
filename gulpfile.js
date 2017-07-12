const gulp = require('gulp')
const pug = require('gulp-pug')
const fileMappings = require('./fileMappings')

gulp.task('compile-views', () => {
  gulp.src(fileMappings.views)
    .pipe(pug())
    .pipe(gulp.dest(fileMappings.distDir))
})

gulp.task('move-vendor', () => {
  gulp.src('node_modules/materialize-css/**/*.*')
    .pipe(gulp.dest(`${fileMappings.vendorDir}/materialize`))

  gulp.src('node_modules/jquery/**/*.*')
    .pipe(gulp.dest(`${fileMappings.vendorDir}/jquery`))

  return new Promise((resolve) => {
    setTimeout(() => { resolve() }, 1000)
  })
})

gulp.task('move-public', ['move-vendor'], () => {
  gulp.src('public/**/*.*')
    .pipe(gulp.dest(fileMappings.distDir))
})

gulp.task('default', ['compile-views', 'move-public'])
