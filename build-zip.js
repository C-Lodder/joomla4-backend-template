const { createWriteStream } = require('fs')
const archiver = require('archiver')
const pkg = require('./package.json')

const output = createWriteStream(`${__dirname}/tpl_bettum-v${pkg.version}.zip`)

const template = archiver('zip', {
  zlib: { level: 9 }
})

// Listen for all archive data to be written
output.on('close', () => {
  console.log(`Template has been packaged successfully`)
})

// Catch this error explicitly
template.on('error', (err) => {
  throw err
})
 
// Pipe archive data to the file
template.pipe(output)

// Append the files and directories
template.file('component.php')
template.file('cpanel.php')
template.file('error.php')
template.file('error_full.php')
template.file('error_login.php')
template.file('favicon.ico')
template.file('index.php')
template.file('joomla.asset.json')
template.file('login.php')
template.file('offline.php')
template.file('template_preview.png')
template.file('template_thumbnail.png')
template.file('templateDetails.xml')
template.directory('css/')
template.directory('html/')
template.directory('images/')
template.directory('js/')
template.directory('language/')
template.directory('webfonts/')

// Finalise the template (ie we are done appending files but streams have to finish yet)
template.finalize()

