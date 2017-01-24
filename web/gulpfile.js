// Include gulp.
var gulp = require('gulp');

// Include plug-ins.
const standard = require('gulp-standard'),
  changed = require('gulp-changed'),
  imagemin = require('gulp-imagemin'),
  concat = require('gulp-concat'),
  stripDebug = require('gulp-strip-debug'),
  uglify = require('gulp-uglify'),
  sourcemaps = require('gulp-sourcemaps'),
  sass = require('gulp-sass'),
  autoprefix = require('gulp-autoprefixer'),
  base64 = require('gulp-base64'),
  minifyCSS = require('gulp-minify-css'),
  livereload = require('gulp-livereload');

// JS Standard task.
gulp.task('standard', function () {
  return gulp.src(['./js/*.js'])
    .pipe(standard())
    .pipe(standard.reporter('default', {
      breakOnError: true
    }))
});

var condition = './js/resort-map.js';

// JS concat, strip debugging and minify.
gulp.task('scripts', function() {
  gulp.src(['./js/*.js', '!./js/resort-map.js'])
    .pipe(concat('script.js'))
    .pipe(stripDebug())
    .pipe(uglify())
    .pipe(gulp.dest('./build/scripts/'));
});

// Minify new images.
gulp.task('imagemin', function() {
  var imgSrc = './images/**/*',
    imgDst = './build/images';

  gulp.src(imgSrc)
    .pipe(changed(imgDst))
    .pipe(imagemin())
    .pipe(gulp.dest(imgDst));
});

// SASS compiler.
gulp.task('sass', function () {
  return gulp.src('./sass/**/*.scss')
    .pipe(sourcemaps.init())
    .pipe(sass().on('error', sass.logError))
    .pipe(gulp.dest('./css'));
});

// CSS concat, auto-prefix, update datauris and minify.
gulp.task('styles', function() {
  gulp.src(['./css/*.css'])
    .pipe(concat('styles.css'))
    .pipe(autoprefix('last 2 versions'))
    .pipe(base64({
      maxImageSize: 8*1024, // bytes
      debug: true
    }))
    .pipe(minifyCSS())
    .pipe(gulp.dest('./build/css/'))
    .pipe(livereload());
});

// Watch tasks.
gulp.task('watch', function () {
  livereload.listen();
  gulp.watch('./js/*.js', ['standard']);
  gulp.watch('./js/*.js', ['scripts']);
  gulp.watch('./images/*', ['imagemin']);
  gulp.watch('./sass/**/*.scss', ['sass']);
  gulp.watch('./css/*.css', ['styles']);
});

// Default task (so that we just call $ gulp to kick this off).
gulp.task('default', ['standard', 'scripts', 'imagemin', 'sass', 'styles', 'watch']);