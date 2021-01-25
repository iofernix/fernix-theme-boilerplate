import { argv } from 'yargs';

import gulp from 'gulp';
import autoprefixer from 'gulp-autoprefixer';
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
import phpcs from 'gulp-phpcs';
import rename from 'gulp-rename';
import sass from 'gulp-sass';
import sasslint from 'gulp-sass-lint';
import source from 'vinyl-source-stream';
import uglify from 'gulp-uglify';

dotenv.config();

const build_path = process.env.THEME_PATH || './build';
const phpcs_path = process.env.PHPCS_PATH || './phpcs';

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
gulp.task('copy:assets', () =>
  gulp.src(['./src/LICENSE', './src/**/*.{md,txt}'])
    .pipe(gulp.dest(build_path))
);
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
gulp.task('copy', gulp.series('copy:assets', 'copy:fonts', 'copy:images', 'copy:plugins'));

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
gulp.task('lint:php', function () {
    return gulp.src(['src/**/*.php', '!src/vendor/**/*'])
        .pipe(phpcs({
            bin: phpcs_path,
            standard: 'WordPress'
        }))
        .pipe(phpcs.reporter('fail'));
});
gulp.task('lint', gulp.parallel('lint:css', 'lint:js', 'lint:php'));

/* Minify */
/* ======================================================== */
gulp.task('minify:js', () =>
    gulp.src(build_path + '/scripts/**/*.js')
        .pipe(uglify())
        .pipe(gulp.dest(build_path  + '/scripts'))
);
gulp.task('minify:css', () =>
    gulp.src(build_path + '/**/*.css')
        .pipe(cleancss())
        .pipe(gulp.dest(build_path))
);
gulp.task('minify', gulp.parallel('minify:css', 'minify:js'));

/* Version */
/* ======================================================== */
gulp.task('version:check', (done) => {
  let author = argv.author || argv.an || null;
  let version = getVersion(argv.number || argv.n || pkg.version);

  if(compare(pkg.version, version) != 0) {
    done(new Error('Version not match. Please check your project version or run gulp version:update -n v${version}'));
  }
});
gulp.task('version:update', () => {
  let version = getVersion(argv.number || argv.n || pkg.version);

  return gulp.src(versioning_files, { base: './' })
    .pipe(bump({
      version: version
    }))
    .pipe(gulp.dest('./'));
});

/* Watch */
/* ======================================================== */
gulp.task('watch:php', () =>
  gulp.watch('./src/**/*.php', gulp.series('build:php'))
);
gulp.task('watch:js', () =>
  gulp.watch('./src/**/*.jsx', gulp.series('build:js'))
);
gulp.task('watch:images', () =>
  gulp.watch('./src/**/*.{jpg,png,gif,svg}', gulp.series('copy:images'))
);
gulp.task('watch:css', () =>
  gulp.watch('./src/**/*.scss', gulp.series('build:css'))
);
gulp.task('watch', gulp.parallel('watch:css', 'watch:js', 'watch:images', 'watch:php'));

/* Theme */
/* ======================================================== */
gulp.task('theme:build', (done) => {
    if(!argv.minify) {
        return gulp.series('build', 'copy')(done);
    }else {
        return gulp.series('build', 'copy', 'minify')(done);
    }
});
gulp.task('theme:deploy', () => {
  let path = argv.path || './dist';

  del.sync([path + '/*', '!' + path + '/.github/workflows'], { force: true });

  return gulp.src(build_path + '/**/*')
    .pipe(gulp.dest(path))
});
gulp.task('theme:watch', gulp.series('build', 'copy', 'watch'));
