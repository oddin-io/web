const gulp = require('gulp')
const pug = require('gulp-pug')

const distFolder = 'dist'

const views = 'views/**/*.pug'

gulp.task('views', () => {
  gulp.src(views)
    .pipe(pug())
    .pipe(gulp.dest(`${distFolder}/views`))
})

gulp.task('default', ['views'])
