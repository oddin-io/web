const gulp = require('gulp')
const pug = require('gulp-pug')
const fileMappings = require('./fileMappings')

gulp.task('views', () => {
  gulp.src(fileMappings.views)
    .pipe(pug())
    .pipe(gulp.dest(fileMappings.distDir))
})

gulp.task('move-public', () => {
  gulp.src('public/**/*')
    .pipe(gulp.dest(fileMappings.distDir))
})

gulp.task('default', ['views', 'move-public'])
