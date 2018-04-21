/*
 * Copyright (c) 2018.
 * github.com/amg262
 * andrewmgunn26@gmail.com
 */

// Require our dependencies
//const babel = require("gulp-babel");
const gulp = require("gulp");
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");
const imagemin = require("gulp-imagemin");
const del = require("del");
const clean = require("gulp-clean");
const rename = require("gulp-rename");
const browserSync = require("browser-sync").create();
const cssnano = require("gulp-cssnano");
const zip = require('gulp-zip');
const unzip = require('gulp-unzip');
const minimatch = require('minimatch');
const mkdirp = require('mkdirp');


var paths = {
    assets: "assets/",
    wasser: "wasser/",
    home: "functions.php",
    scripts: "wasser/scripts.js",
    styles: "wasser/styles.css",
    logs: "wasser/logs/",
};

// Not all tasks need to use streams
// A gulpfile is just another node program and you can use any package available on npm
gulp.task("purge", function () {
    gulp.src(paths.wasser + "*.min.js")
        .pipe(clean());
    gulp.src(paths.wasser + "*.min.css")
        .pipe(clean());
});

// Copy all static images
gulp.task("imagemin", function () {
    //    .pipe(imagemin())
    //   .pipe(gulp.dest(paths.dist_img));
});

gulp.task("cssnano", function () {
    gulp.src(paths.lib_css)
        .pipe(cssnano())
        .pipe(rename({suffix: ".min"}))
        .pipe(gulp.dest(paths.wasser))
});


gulp.task('scripts', function () {
    //return gulp.src(paths.data)
    //   .pipe(concat('*'))
    //  .pipe(gulp.dest('archive'));
});

/**
 * Minify compiled JavaScript.
 *
 * https://www.npmjs.com/package/gulp-uglify
 */
gulp.task("uglify", function () {

    gulp.src(paths.lib_js)
        .pipe(uglify())
        .pipe(rename({suffix: ".min"}))
        .pipe(gulp.dest(paths.wasser));
});

gulp.task('zip', function () {
    //  gulp.src('assets/data/*')
    //     .pipe(zip('archive.zip'))
    //    .pipe(gulp.dest('assets/archive/'))
});


gulp.task('unzip', function () {
    // gulp.src('archive/*')
    //    .pipe(unzip())
    //   .pipe(gulp.dest('dist'))
});

// Static Server + watching scss/html files
gulp.task("serve", function () {

    browserSync.init({
        proxy: "http://localhost/wasser/wp-admin"
    });

});

// Rerun the task when a file changes
gulp.task("watch", function () {
    //gulp.watch(paths.scripts, ["scripts"]);
    gulp.watch('*.php').on("change", browserSync.reload);
    gulp.watch('wasser/*.php').on("change", browserSync.reload);
    gulp.watch('*.css').on("change", browserSync.reload);
    gulp.watch('wasser/*.css').on("change", browserSync.reload);
    gulp.watch('modules/content/*.php').on("change", browserSync.reload);
});

//gulp.task("default", ["purge", "imagemin", "cssnano", "uglify", "serve", "watch"]);
gulp.task("default", ["purge", "imagemin", "cssnano", "uglify", "serve", "watch"]);
gulp.task("build", ["purge", "cssnano", "uglify"]);
gulp.task("clean", ["purge", "cssnano", "uglify", "serve", "watch"]);
gulp.task("live", ["serve", "watch"]);

