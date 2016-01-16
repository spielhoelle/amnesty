var gulp = require('gulp'),
    sass = require('gulp-sass'),
    sourcemaps = require('gulp-sourcemaps'),
    autoprefixer = require('gulp-autoprefixer'),

    scssFiles = [
        'wp-content/themes/amnesty/**/*.scss'
    ];

gulp.task('scss', function() {
    gulp.src(scssFiles, {base: 'wp-content/themes/amnesty'})
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(autoprefixer({
            browsers: ['last 3 versions']
        }))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('wp-content/themes/amnesty'));
});

// watch task
gulp.task('default',function() {
    gulp.watch(scssFiles,['scss']);
});
