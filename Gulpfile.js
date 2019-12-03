/*
 * Build scripts
 */

const gulp         = require('gulp');
const postcss      = require('gulp-postcss');
const sass         = require('gulp-sass');
const autoprefixer = require('autoprefixer');
const cssnano      = require('cssnano');

sass.compiler = require('node-sass');

const postcssPipe = () => 
	postcss([
		autoprefixer(),
		cssnano()
	]);

// Compile the core template SCSS
gulp.task('sass-core', () =>
	gulp.src([
		`./scss/template.scss`,
		`./scss/fonts/fontawesome.scss`,
		`./scss/pages/login.scss`,
		`./scss/pages/dashboard.scss`,
		`./scss/pages/system.scss`,
		`./scss/blocks/sidebar_nav.scss`,
	])
		.pipe(sass().on('error', sass.logError))
		.pipe(postcssPipe())
		.pipe(gulp.dest(`./css`))
);

// Compile vendor and Joomla SCSS overrides
gulp.task('sass-vendor', async() => {
	const files = {
		'./scss/joomla/joomla-field-media.scss' : './css/system/fields',
		'./scss/joomla/switcher.scss' : './css/system/fields',
		'./scss/joomla/calendar.scss' : './css/system/fields',
		'./scss/joomla/installer.scss' : './css/com_installer',
		'./scss/vendor/minicolors.scss' : './css/vendor/minicolors',
		'./scss/vendor/choices.scss' : './css/vendor/choicesjs',
		'./scss/vendor/dragula.scss' : './css/vendor/dragula',
		'./scss/vendor/custom-elements/joomla-tab.scss' : './css/vendor/joomla-custom-elements',
		'./scss/pages/com_media/mediamanager.scss' : './css/com_media',
	};

	return Object.entries(files).forEach(([file, dest]) =>
		gulp.src(`${file}`)
			.pipe(sass().on('error', sass.logError))
			.pipe(postcssPipe())
			.pipe(gulp.dest(`${dest}`))
	);
});

// Global build task consisting of all sub-tasks
gulp.task('build', gulp.series(
	'sass-core',
	'sass-vendor',
));
