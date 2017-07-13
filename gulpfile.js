const gulp = require('gulp')
const pug = require('gulp-pug')
const exec = require('child_process').exec
const bluebird = require('bluebird')
const fileMappings = require('./fileMappings')

gulp.task('compile-views', () => {
  gulp.src(fileMappings.views)
    .pipe(pug())
    .pipe(gulp.dest(fileMappings.distDir))
})

gulp.task('move-vendor', () => {
  const materialize = new Promise((resolve) => {
    gulp.src('node_modules/materialize-css/**/*.*')
    .pipe(gulp.dest(`${fileMappings.vendorDir}/materialize`))
    .once('end', resolve)
  })

  const jquery = new Promise((resolve) => {
    gulp.src('node_modules/jquery/**/*.*')
    .pipe(gulp.dest(`${fileMappings.vendorDir}/jquery`))
    .once('end', resolve)
  })

  return bluebird.all([materialize, jquery])
})

gulp.task('move-public', ['move-vendor'], () => {
  gulp.src('public/**/*')
    .pipe(gulp.dest(fileMappings.distDir))
})

gulp.task('compile-modules', () => {
  return new Promise((resolve, reject) => {
    exec('webpack', (err) => {
      if (err) return reject(err)
      return resolve()
    })
  })
})

gulp.task('default', ['compile-views', 'move-public', 'compile-modules'])
