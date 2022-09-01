/*
 * Build scripts
 */

const { copyFile, mkdir, readdir, rm } = require('fs').promises
const { join } = require('path')
const gulp = require('gulp')
const postcss = require('gulp-postcss')
const sass = require('gulp-sass')(require('sass'));
const header = require('gulp-header')
const rename = require('gulp-rename')
const autoprefixer = require('autoprefixer')
const cssnano = require('cssnano')

const postcssPipe = () =>
  postcss([
    autoprefixer(),
    cssnano()
  ])

const renamePipe = () =>
  rename({
    extname: '.css'
  })

async function copyDir(src, dest) {
  await rm(dest, { recursive: true, force: true })
  await mkdir(dest, { recursive: true })
  const entries = await readdir(src, { withFileTypes: true })

  for (let entry of entries) {
    const srcPath = join(src, entry.name)
    const destPath = join(dest, entry.name)

    entry.isDirectory() ?
      await copyDir(srcPath, destPath) :
      await copyFile(srcPath, destPath)
  }
}

// Compile the core template SCSS
gulp.task('copy', () =>
  copyDir(`${__dirname}/node_modules/bootstrap/scss`, `${__dirname}/sass/bootstrap`)
)

// Compile the core template SCSS
gulp.task('sass-core', () =>
  gulp.src([
    `./sass/template.scss`,
    `./sass/template-light.scss`,
    `./sass/fonts/fontawesome.scss`,
    `./sass/pages/login.scss`,
    `./sass/pages/dashboard.scss`,
    `./sass/pages/system.scss`,
    `./sass/blocks/sidebar_nav.scss`,
  ])
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(postcssPipe())
    .pipe(renamePipe())
    .pipe(gulp.dest(`./css`))
)

gulp.task('sass-rtl', () =>
  gulp.src([
    `./sass/template-rtl.scss`,
    `./sass/blocks/sidebar_nav-rtl.scss`,
  ])
    .pipe(header('$rtl: true;\n'))
    .pipe(sass.sync().on('error', sass.logError))
    .pipe(postcssPipe())
    .pipe(renamePipe())
    .pipe(gulp.dest(`./css`))
)

// Compile vendor and Joomla SCSS overrides
gulp.task('sass-vendor', async() => {
  const files = {
    './sass/joomla/searchtools.scss' : './css/system/searchtools',
    './sass/media/system/fields/joomla-field-media.scss' : './css/system/fields',
    './sass/media/system/fields/switcher.scss' : './css/system/fields',
    './sass/media/system/fields/calendar.scss' : './css/system/fields',
    './sass/media/com_installer/installer.scss' : './css/com_installer',
    './sass/media/com_media/media-manager.scss' : './css/com_media',
    './sass/media/plg_installer_webinstaller/client.scss' : './css/plg_installer_webinstaller',
    './sass/media/vendor/minicolors.scss' : './css/vendor/minicolors',
    './sass/media/vendor/choices.scss' : './css/vendor/choicesjs',
    './sass/media/vendor/dragula.scss' : './css/vendor/dragula',
    './sass/media/vendor/custom-elements/joomla-tab.scss' : './css/vendor/joomla-custom-elements',
    './sass/media/vendor/custom-elements/joomla-alert.scss' : './css/vendor/joomla-custom-elements',
  }

  return Object.entries(files).forEach(([file, dest]) =>
    gulp.src(`${file}`)
      .pipe(sass.sync().on('error', sass.logError))
      .pipe(postcssPipe())
      .pipe(renamePipe())
      .pipe(gulp.dest(`${dest}`))
  )
})

// Global build task consisting of all sub-tasks
gulp.task('build', gulp.series(
  'copy',
  'sass-core',
  'sass-rtl',
  'sass-vendor',
))
