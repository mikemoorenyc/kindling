var buildDir = 'realestate';

//GENERAL MODULES
var gulp = require('gulp'),
    concat = require('gulp-concat'),
    changed = require('gulp-changed');




const babel = require('gulp-babel');
//MOVER
function mover(original, destination) {
  return gulp.src(original)
    .pipe(gulp.dest(destination));
}
//SASS processo
function sassProcess(original, destination) {
  var sass = require('gulp-sass'),
      postcss = require('gulp-postcss'),
      mqpacker = require('css-mqpacker'),
      autoprefixer = require('autoprefixer');
      var processors = [
        autoprefixer({ browsers: ['last 2 versions'] }),
        mqpacker
      ];
  return gulp.src(original)
    .pipe(sass().on('error', sass.logError))
    .pipe(postcss(processors))
    .pipe(gulp.dest(destination));
}
//CSS PROCESSING
gulp.task('sass', function () {
  sassProcess(['sass/main.scss', 'sass/expanded.scss','sass/ie-fixes.scss','sass/editor-styles.scss'], '../'+buildDir+'/css');
});

//JAVASCRIPT PROCESSING

var    jshint = require('gulp-jshint');

gulp.task('js', function () {
  gulp.src([  'js/site.js', 'js/modules/*.js'])
    .pipe(babel({
        presets: ['es2015']
    }))
    .pipe(concat('main.js'))
    .pipe(gulp.dest('../'+buildDir+'/js'));
  gulp.src('js/plugins/*.js')
  .pipe(concat('plugins.js'))
  .pipe(gulp.dest('../'+buildDir+'/js'));
  gulp.src('js/inline-load.js')
    .pipe(gulp.dest('../'+buildDir+'/js'));
});

gulp.task('lint', function() {
  return gulp.src(['js/site.js', 'modules/*.js', 'js/inline-load.js'])
    .pipe(jshint())
    .pipe(jshint.reporter('default'));
});

//HTML PROCESSING

gulp.task('templatecrush', function() {
  gulp.src(['*.php','*.html','!custom-module-functions.php'])
    .pipe(changed('../'+buildDir))
    .pipe(gulp.dest('../'+buildDir));
});

//IMAGE PROCESSING
var svgstore = require('gulp-svgstore');

gulp.task('svgstore', function () {
    return gulp
        .src('assets/svgs/*.svg')
        .pipe(svgstore({ inlineSvg: true }))
        .pipe(gulp.dest('../'+buildDir+'/assets'));
});

gulp.task('imgmin', function () {
  gulp.src('assets/imgs/**/*')
    .pipe(changed('../'+buildDir+'/assets/imgs'))
    .pipe(gulp.dest('../'+buildDir+'/assets/imgs'));
});

//

//DUMPS
gulp.task('fontdump', function(){
  gulp.src('assets/fonts/**/*')
    .pipe(gulp.dest('../'+buildDir+'/assets/fonts'));
});

gulp.task('wpdump', function(){
  gulp.src(['style.css', 'screenshot.png'])
    .pipe(gulp.dest('../'+buildDir));
});

gulp.task('backend-modules', function(){

  gulp.src(['backend-modules/**/*.html', 'backend-modules/**/*.php'])
    .pipe(changed('../'+buildDir+'/backend-modules'))
    .pipe(gulp.dest('../'+buildDir+'/backend-modules'));


  sassProcess('backend-modules/**/*.scss', '../'+buildDir+'/backend-modules')

  gulp.src('backend-modules/**/*.js')
          .pipe(babel({
              presets: ['es2015']
          }))
          .pipe(gulp.dest('../'+buildDir+'/backend-modules'));


});

gulp.task('watch', function() {
    gulp.watch('js/**/*.js', ['js']);
    gulp.watch(['sass/**/*'], ['sass']);
    gulp.watch('assets/imgs/**/*', ['imgmin']);
    gulp.watch('assets/fonts/**/*', ['fontdump']);
    gulp.watch(['*.php', '*.html'], ['templatecrush']);
//    gulp.watch(['style.css', 'screenshot.png'], ['wpdump']);
  gulp.watch(['assets/svgs/*.svg'], ['svgstore']);
gulp.watch(['backend-modules/**/*'], ['backend-modules']);

});
gulp.task('build', [ 'js', 'imgmin', 'templatecrush', 'fontdump', 'wpdump','sass', 'svgstore']);
