/*
 * Build scripts
 */

const gulp         = require('gulp')
const postcss      = require('gulp-postcss')
const sass         = require('gulp-sass')
const header       = require('gulp-header')
const autoprefixer = require('autoprefixer')
const cssnano      = require('cssnano')

sass.compiler = require('node-sass')

const postcssPipe = () => 
	postcss([
		autoprefixer(),
		cssnano()
	])

// Compile the core template SCSS
gulp.task('sass-core', () =>
	gulp.src([
		`./scss/template.scss`,
		//`./scss/template-light.scss`,
		`./scss/fonts/fontawesome.scss`,
		`./scss/pages/login.scss`,
		`./scss/pages/dashboard.scss`,
		`./scss/pages/system.scss`,
		`./scss/blocks/sidebar_nav.scss`,
	])
		.pipe(sass().on('error', sass.logError))
		.pipe(postcssPipe())
		.pipe(gulp.dest(`./css`))
)

gulp.task('sass-rtl', () =>
	gulp.src([
		`./scss/template-rtl.scss`,
		`./scss/blocks/sidebar_nav-rtl.scss`,
	])
		.pipe(header('$rtl: true;\n'))
		.pipe(sass().on('error', sass.logError))
		.pipe(postcssPipe())
		.pipe(gulp.dest(`./css`))
)

// Compile vendor and Joomla SCSS overrides
gulp.task('sass-vendor', async() => {
	const files = {
		'./scss/joomla/searchtools.scss' : './css/system/searchtools',
		'./scss/media/system/fields/joomla-field-media.scss' : './css/system/fields',
		'./scss/media/system/fields/switcher.scss' : './css/system/fields',
		'./scss/media/system/fields/calendar.scss' : './css/system/fields',
		'./scss/media/com_installer/installer.scss' : './css/com_installer',
		'./scss/media/com_media/mediamanager.scss' : './css/com_media',
		'./scss/media/plg_installer_webinstaller/client.scss' : './css/plg_installer_webinstaller',
		'./scss/media/vendor/minicolors.scss' : './css/vendor/minicolors',
		'./scss/media/vendor/choices.scss' : './css/vendor/choicesjs',
		'./scss/media/vendor/dragula.scss' : './css/vendor/dragula',
		'./scss/media/vendor/custom-elements/joomla-tab.scss' : './css/vendor/joomla-custom-elements',
		'./scss/media/vendor/custom-elements/joomla-alert.scss' : './css/vendor/joomla-custom-elements',
	}

	return Object.entries(files).forEach(([file, dest]) =>
		gulp.src(`${file}`)
			.pipe(sass().on('error', sass.logError))
			.pipe(postcssPipe())
			.pipe(gulp.dest(`${dest}`))
	)
})

// Global build task consisting of all sub-tasks
gulp.task('build', gulp.series(
	'sass-core',
	'sass-rtl',
	'sass-vendor',
))
