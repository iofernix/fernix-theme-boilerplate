import { argv } from 'yargs';

import gulp from 'gulp';
import autoprefixer from 'gulp-autoprefixer';
import browser from 'browser-sync';
import browserify from 'browserify';
import bump from 'gulp-bump';
import cleancss from 'gulp-clean-css';
import compare from 'compare-versions';
import del from 'del';
import dotenv from 'dotenv';
import es from 'event-stream';
import eslint from 'gulp-eslint';
import glob from 'glob';
import pkg from './package.json';
import rename from 'gulp-rename';
import sass from 'gulp-sass';
import sasslint from 'gulp-sass-lint';
import source from 'vinyl-source-stream';
import uglify from 'gulp-uglify';

browser.create();
dotenv.config();

const build_path = process.env.WP_THEME_PATH || process.env.BUILD_PATH || './build';
const dist_path = process.env.DIST_PATH || './dist';

const versioning_files = [
  'package.json',
  'src/style.scss'
];

const getVersion = (version) => {
  let vpos = version.indexOf('v');

  return version.substring(vpos + 1);
}

/* Build */
/* ======================================================== */
gulp.task('build:php', () =>
  gulp.src('./src/**/*.php')
    .pipe(gulp.dest(build_path))
);
gulp.task('build:js', gulp.series(
  (done) => {
    glob('./src/**/*.jsx', {
      'ignore': ['./src/scripts/**/*.jsx']
    }, (err, files) => {
      if(err) done(err);
      var tasks = files.map((entry) =>
        browserify({
          entries: [entry],
          extensions: ['.js','.jsx'],
          debug: false
        })
        .transform('babelify', {
          presets: ["@babel/preset-env", "@babel/preset-react"]
        })
        .bundle()
        .pipe(source(entry))
        .pipe(rename({ extname: '.js' }))
        .pipe(gulp.dest('./.tmp'))
      );
      es.merge(tasks).on('end', done);
    })
  },
  () => gulp.src('./.tmp/src/**/*.js')
          .pipe(gulp.dest(build_path)),
  () => del('./.tmp')
));
gulp.task('build:css', () =>
  gulp.src('./src/**/*.scss')
    .pipe(sass({
      outputStyle: 'expanded',
      includePaths: ['./src/styles', './node_modules']
    }).on('error', sass.logError))
    .pipe(autoprefixer())
    .pipe(gulp.dest(build_path))
);
gulp.task('build:clean', () => del(build_path + '/*', { force: true }));
gulp.task('build', gulp.series('build:clean', 'build:css', 'build:js', 'build:php'));

/* Copy */
/* ======================================================== */
gulp.task('copy:fonts', () =>
  gulp.src(['./src/**/*.{ttf}'])
    .pipe(gulp.dest(build_path + '/fonts'))
);
gulp.task('copy:images', () =>
  gulp.src(['./src/**/*.{jpg,png,gif,svg}', '!./src/images/sprites/**/*'])
    .pipe(gulp.dest(build_path))
);
gulp.task('copy:plugins', () =>
  gulp.src('./src/plugins/**/*')
    .pipe(gulp.dest(build_path + '/plugins'))
);
gulp.task('copy', gulp.series('copy:fonts', 'copy:images', 'copy:plugins'));

/* Lint */
/* ======================================================== */
gulp.task('lint:js', () =>
  gulp.src(['./src/**/*.jsx'])
    .pipe(eslint({
      configFile: '.eslintrc.json'
    }))
    .pipe(eslint.format())
    .pipe(eslint.failAfterError())
);
gulp.task('lint:css', () =>
  gulp.src('./src/**/*.scss')
    .pipe(sasslint({
      configFile: '.scss-lint.yml'
    }))
    .pipe(sasslint.format())
    .pipe(sasslint.failOnError())
);
gulp.task('lint', gulp.series('lint:css', 'lint:js'));

/* Release */
/* ======================================================== */
gulp.task('release:php', gulp.series('build:php',
  () => gulp.src(build_path + '/**/*.php')
        .pipe(gulp.dest(dist_path))
));
gulp.task('release:js', gulp.series('build:js',
  () => gulp.src(build_path + '/scripts/**/*.js')
        .pipe(uglify())
        .pipe(rename({ extname: '.min.js' }))
        .pipe(gulp.dest(dist_path  + '/scripts'))
));
gulp.task('release:images', gulp.series('copy:images',
  () => gulp.src(build_path + '/**/*.{jpg,png,gif,svg}')
        .pipe(gulp.dest(dist_path))
));
gulp.task('release:css', gulp.series('build:css',
  () => gulp.src(build_path + '/**/*.css')
        .pipe(cleancss())
        .pipe(gulp.dest(dist_path))
));
gulp.task('release:clean', () => del(dist_path, { force: true }));
gulp.task('release', gulp.series('release:clean', 'release:css', 'release:images', 'release:js', 'release:php'));

/* Watch */
/* ======================================================== */
gulp.task('watch:php', () =>
  gulp.watch('./src/**/*.php', gulp.series('build:php')).on('change', browser.reload)
);
gulp.task('watch:js', () =>
  gulp.watch('./src/**/*.jsx', gulp.series('build:js')).on('change', browser.reload)
);
gulp.task('watch:images', () =>
  gulp.watch('./src/**/*.{jpg,png,gif,svg}', gulp.series('copy:images')).on('change', browser.reload)
);
gulp.task('watch:css', () =>
  gulp.watch('./src/**/*.scss', gulp.series('build:css')).on('change', browser.reload)
);
gulp.task('watch', gulp.parallel('watch:css', 'watch:js', 'watch:images', 'watch:php'));

/* Version */
/* ======================================================== */
gulp.task('version:bump', () => {
  let file = argv.file || 'package.json';
  let key = argv.key || 'version';
  let output = argv.output || '';
  let preid = argv.preid || '';
  let type = argv.type || 'patch';
  let version = argv.Version || '';

  return gulp.src(file, { base: './' })
    .pipe(bump({
      key: key,
      type: type,
      preid: preid,
      version: version
    }))
    .pipe(gulp.dest('./'));
});
gulp.task('version:check', (done) => {
  let author = argv.author || argv.an || null;
  let version = getVersion(argv.number || argv.n || pkg.version);

  if(compare(pkg.version, version) != 0) {
    done(new Error('Version not match. Please check your project version or run gulp version:update -n v${version}'));
  }
});
gulp.task('version:deploy', () => {
  let path = argv.path || dist_path;

  del.sync(path + '/*', { force: true });

  return gulp.src(build_path + '/**/*')
    .pipe(gulp.dest(path))
});
gulp.task('version:update', () => {
  let version = getVersion(argv.number || argv.n || pkg.version);

  return gulp.src(versioning_files, { base: './' })
    .pipe(bump({
      version: version
    }))
    .pipe(gulp.dest('./'));
});

/* Theme */
/* ======================================================== */
gulp.task('theme:build', gulp.series('build', 'copy'));
gulp.task('theme:deploy', () => {
  let path = argv.path || dist_path;

  del.sync(path + '/*', { force: true });

  return gulp.src(build_path + '/**/*')
    .pipe(gulp.dest(path))
});
gulp.task('theme:server', () => {
  browser.init({
    proxy: process.env.WP_URL
  });
});
gulp.task('theme:watch', gulp.series('build', 'copy', 'watch'));
gulp.task('theme', gulp.series('build', 'copy', gulp.parallel('watch', 'theme:server')));
