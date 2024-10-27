const gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
const concat = require('gulp-concat');

gulp.task('scss', function() {
  return gulp.src('./public/styles/scss/*.scss')
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(concat('styles.css'))
    .pipe(gulp.dest('./public/styles/css'))
    .pipe(gulp.dest(function(f) {
      console.log('Output file:', f.path);
      return f.base;
    }));
});

gulp.task('watch-scss', function() {
  gulp.watch('public/styles/scss/*.scss', gulp.series('scss'));
});