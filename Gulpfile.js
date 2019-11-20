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
gulp.task('sass-core', () =>
	gulp.src([
		`./scss/template.scss`,
		`./scss/fonts/fontawesome.scss`,
		`./scss/pages/login.scss`,
		`./scss/pages/dashboard.scss`,
		`./scss/pages/system.scss`,
	])
		.pipe(sass().on('error', sass.logError))
		.pipe(gulp.dest(`./css`))
);

// Vendor and other CSS overrides
gulp.task('sass-vendor', async () => {
	const files = {
		'./scss/joomla/joomla-field-media.scss' : './css/system/fields',
		'./scss/joomla/switcher.scss' : './css/system/fields',
		'./scss/joomla/calendar.scss' : './css/system/fields',
		'./scss/joomla/installer.scss' : './css/com_installer',
		'./scss/vendor/minicolors.scss' : './css/vendor/minicolors',
		'./scss/vendor/choices.scss' : './css/vendor/choicesjs',
		'./scss/vendor/dragula.scss' : './css/vendor/dragula',
		'./scss/vendor/custom-elements/joomla-tab.scss' : './css/vendor/joomla-custom-elements',
	};

	return Object.entries(files).forEach(([file, dist]) => {
		return gulp.src(`${file}`)
			.pipe(sass().on('error', sass.logError))
			.pipe(gulp.dest(`${dist}`))
	});
});

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
	'sass-core',
	'sass-vendor',
	'postcss',
));
