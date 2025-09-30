// ## Globals
var argv         = require('minimist')(process.argv.slice(2));
var autoprefixer = require('gulp-autoprefixer');
var browserSync  = require('browser-sync').create();
var changed      = require('gulp-changed');
var concat       = require('gulp-concat');
var flatten      = require('gulp-flatten');
var gulp         = require('gulp');
var gulpif       = require('gulp-if');
var imagemin     = require('gulp-imagemin');
var lazypipe     = require('lazypipe');
var less         = require('gulp-less');
var merge        = require('merge-stream');
var cssNano      = require('gulp-cssnano');
var plumber      = require('gulp-plumber');
var rev          = require('gulp-rev');
var sass         = require('gulp-sass')(require('sass'));
var sourcemaps   = require('gulp-sourcemaps');
var uglify       = require('gulp-uglify');
var del          = require('del');

// See https://github.com/austinpray/asset-builder
var manifest = require('asset-builder')('./assets/manifest.json');
var path = manifest.paths;
var config = manifest.config || {};
var globs = manifest.globs;
var project = manifest.getProjectGlobs();

var enabled = {
  rev: argv.production,
  maps: !argv.production,
  failStyleTask: argv.production,
  stripJSDebug: argv.production
};

var revManifest = path.dist + 'assets.json';

// ## Reusable Pipelines
var cssTasks = function(filename) {
  return lazypipe()
    .pipe(function() { return gulpif(!enabled.failStyleTask, plumber()); })
    .pipe(function() { return gulpif(enabled.maps, sourcemaps.init()); })
    .pipe(function() { return gulpif('*.less', less()); })
    .pipe(function() { return gulpif('*.scss', sass({
      outputStyle: 'nested',
      precision: 10,
      includePaths: ['.']
    }).on('error', sass.logError)); })
    .pipe(concat, filename)
    .pipe(autoprefixer, {
      overrideBrowserslist: [
        'last 2 versions',
        'android 4',
        'opera 12'
      ]
    })
    .pipe(cssNano, { safe: true })
    .pipe(function() { return gulpif(enabled.rev, rev()); })
    .pipe(function() { return gulpif(enabled.maps, sourcemaps.write('.', { sourceRoot: 'assets/styles/' })); })();
};

var jsTasks = function(filename) {
  return lazypipe()
    .pipe(function() { return gulpif(enabled.maps, sourcemaps.init()); })
    .pipe(concat, filename)
    .pipe(uglify, { compress: { 'drop_debugger': enabled.stripJSDebug } })
    .pipe(function() { return gulpif(enabled.rev, rev()); })
    .pipe(function() { return gulpif(enabled.maps, sourcemaps.write('.', { sourceRoot: 'assets/scripts/' })); })();
};

var writeToManifest = function(directory) {
  return lazypipe()
    .pipe(gulp.dest, path.dist + directory)
    .pipe(browserSync.stream, {match: '**/*.{js,css}'})
    .pipe(rev.manifest, revManifest, { base: path.dist, merge: true })
    .pipe(gulp.dest, path.dist)();
};

// ## Gulp tasks
gulp.task('styles', async function stylesTask() {
  var streams = [];
  manifest.forEachDependency('css', function(dep) {
    var cssTasksInstance = cssTasks(dep.name);
    if (!enabled.failStyleTask) {
      cssTasksInstance.on('error', function(err) {
        console.error(err.message);
        this.emit('end');
      });
    }
    streams.push(gulp.src(dep.globs, {base: 'styles'}).pipe(cssTasksInstance));
  });

  if (streams.length === 0) {
    return;
  }

  return merge(streams).pipe(writeToManifest('styles'));
});

gulp.task('scripts', async function scriptsTask() {
  var streams = [];
  manifest.forEachDependency('js', function(dep) {
    streams.push(gulp.src(dep.globs, {base: 'scripts'}).pipe(jsTasks(dep.name)));
  });

  if (streams.length === 0) {
    return;
  }

  return merge(streams).pipe(writeToManifest('scripts'));
});

gulp.task('fonts', function fontsTask() {
  return gulp.src(globs.fonts)
    .pipe(flatten())
    .pipe(gulp.dest(path.dist + 'fonts'))
    .pipe(browserSync.stream());
});

gulp.task('images', function imagesTask() {
  return gulp.src(globs.images)
    .pipe(imagemin({ progressive: true, interlaced: true, svgoPlugins: [{removeUnknownsAndDefaults: false}, {cleanupIDs: false}] }))
    .pipe(gulp.dest(path.dist + 'images'))
    .pipe(browserSync.stream());
});

gulp.task('clean', function cleanTask() {
  return del([path.dist]);
});

gulp.task('watch', function watchTask() {
  browserSync.init({
    files: ['{lib,templates}/**/*.php', '*.php'],
    proxy: config.devUrl,
    snippetOptions: { whitelist: ['/wp-admin/admin-ajax.php'], blacklist: ['/wp-admin/**'] }
  });
  gulp.watch(path.source + 'styles/**/*', gulp.series('styles'));
  gulp.watch(path.source + 'scripts/**/*', gulp.series('scripts'));
  gulp.watch(path.source + 'fonts/**/*', gulp.series('fonts'));
  gulp.watch(path.source + 'images/**/*', gulp.series('images'));
  gulp.watch(['bower.json', 'assets/manifest.json'], gulp.series('build'));
});

gulp.task('build', gulp.series(
  'styles',
  'scripts',
  gulp.parallel('fonts', 'images')
));

gulp.task('default', gulp.series('clean', 'build'));
