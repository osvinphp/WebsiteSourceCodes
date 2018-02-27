// Dependencies
var gulp = require('gulp');
var babel = require('gulp-babel');
var uglify = require('gulp-uglify');
var cleanCss = require('gulp-clean-css');
var concatCss = require('gulp-concat-css');
var trimlines = require('gulp-trimlines');
var whitespace = require('gulp-whitespace');

// JS Task
gulp.task('uglify-js', function() {

    gulp.src('assets/js/source/*.js')
        .pipe(babel())
        .pipe(uglify())
        .pipe(gulp.dest('assets/js'));
        
    gulp.src('assets/components/js/source/*.js')
        .pipe(uglify())
        .pipe(gulp.dest('assets/components/js'));

});

// JS Task
// gulp.task('trim-js', function() {
//     gulp.src('assets/js/*.js')
//         .pipe(trimlines())
//         .pipe(whitespace({
//             tabsToSpaces: 32,
//             spacesToTabs: 32,
//             removeTrailing: true
//         }))
//         .pipe(gulp.dest('assets/js/wow'));
// });

// CSS Task
gulp.task('clean-css', function() {

    gulp.src('assets/css/source/*.css')
        .pipe(cleanCss())
        .pipe(trimlines())
        .pipe(gulp.dest('assets/css'));

    gulp.src('assets/components/css/source/*.css')
        .pipe(concatCss('app.css'))
        .pipe(cleanCss())
        .pipe(trimlines())
        .pipe(gulp.dest('assets/components/css'));

});

// Gulp Watch For File Change
gulp.task('watch', function() {
    gulp.watch(['assets/js/source/*.js', 'assets/components/js/source/*.js'], ['uglify-js']);
    gulp.watch(['assets/css/source/*.css', 'assets/component/css/source/*.css'], ['clean-css']);
    gulp.watch(['assets/components/js/source/*.js', 'assets/components/components/js/source/*.js'], ['uglify-js']);
    gulp.watch(['assets/components/css/source/*.css', 'assets/component/components/css/source/*.css'], ['clean-css']);
});

// Main Task
gulp.task('default', ['uglify-js', 'clean-css', 'watch']);