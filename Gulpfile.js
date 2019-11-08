/*
 * Build scripts
 */

const gulp         = require('gulp');
const postcss      = require('gulp-postcss');
const sass         = require('gulp-sass');
const autoprefixer = require('autoprefixer');
const cssnano      = require('cssnano');

sass.compiler = require('node-sass');

// Compile the SCSS
gulp.task('sass', () =>
	gulp.src([`./scss/template.scss`, `./scss/fonts/_fontawesome.scss`, `./scss/vendor/_bootstrap.scss`])
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest(`./css`))
);

gulp.task('sass-joomla-installer', () =>
	gulp.src([`./scss/joomla/installer.scss`])
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest(`./css/com_installer`))
);

gulp.task('sass-vendor-minicolors', () =>
	gulp.src([`./scss/vendor/minicolors.scss`])
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest(`./css/vendor/minicolors`))
);

// Additional tasks to run on the compiled CSS file
gulp.task('postcss', () =>
	gulp.src(`./css/**/*.css`)
		.pipe(postcss([
			autoprefixer(),
			cssnano()
		]))
		.pipe(gulp.dest(`./css`))
);

gulp.task('build', gulp.series(
	'sass',
	'sass-joomla-installer',
	'sass-vendor-minicolors',
	'postcss',
));
