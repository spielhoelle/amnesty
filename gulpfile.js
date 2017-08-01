var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS = require('gulp-clean-css'),

    sassFiles = [
        'wp-content/themes/amnesty/**/*.sass'
    ];

gulp.task('sass', function() {
    gulp.src(sassFiles, {base: 'wp-content/themes/amnesty'})
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS({processImport: false}))
        .pipe(autoprefixer({ browsers: ['last 2 versions', 'safari 5', 'ie 11', 'opera 12.1', 'ios 6', 'android 4'] }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('wp-content/themes/amnesty'));
});

// watch task
gulp.task('default',function() {
    gulp.watch(sassFiles,['sass']);
});
