/*
 * Build scripts
 */

const { join } = require('path')
const gulp = require('gulp')
const postcss = require('gulp-postcss')
const { renderSync } = require('sass')
const { obj } = require('through2')
const header = require('gulp-header')
const rename = require('gulp-rename')
const autoprefixer = require('autoprefixer')
const cssnano = require('cssnano')

const compileScss = () =>
	obj(async (file, enc, callback) => {
		if (file.isBuffer()) {
			const string = file.contents.toString('utf8');
			const result = await renderSync({
				data: string,
				includePaths: [join(__dirname, '../../media/vendor/bootstrap/'), `${__dirname}/scss/`],
			});
 
			file.contents = 'from' in Buffer ? Buffer.from(result.css) : new Buffer(result.css);
 
			return callback(null, file);
		}
	});

const postcssPipe = () =>
	postcss([
		autoprefixer(),
		cssnano()
	])

const renamePipe = () =>
	rename({
		extname: '.css'
	})

// Compile the core template SCSS
gulp.task('sass-core', () =>
	gulp.src([
		`./scss/template.scss`,
		`./scss/template-light.scss`,
		`./scss/fonts/fontawesome.scss`,
		`./scss/pages/login.scss`,
		`./scss/pages/dashboard.scss`,
		`./scss/pages/system.scss`,
		`./scss/blocks/sidebar_nav.scss`,
	])
		.pipe(compileScss())
		.pipe(postcssPipe())
		.pipe(renamePipe())
		.pipe(gulp.dest(`./css`))
)

gulp.task('sass-rtl', () =>
	gulp.src([
		`./scss/template-rtl.scss`,
		`./scss/blocks/sidebar_nav-rtl.scss`,
	])
		.pipe(header('$rtl: true;\n'))
		.pipe(compileScss())
		.pipe(postcssPipe())
		.pipe(renamePipe())
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
			.pipe(compileScss())
			.pipe(postcssPipe())
			.pipe(renamePipe())
			.pipe(gulp.dest(`${dest}`))
	)
})

// Global build task consisting of all sub-tasks
gulp.task('build', gulp.series(
	'sass-core',
	'sass-rtl',
	'sass-vendor',
))
