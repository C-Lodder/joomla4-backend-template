const { createWriteStream, promises } = require('fs')
const pkg = require('./package.json')

const updateJoomlaAssetJson = async () => {
  const file = await promises.readFile('./joomla.asset.json', 'utf8')
  const json = JSON.parse(file)

  json.version = pkg.version

  await promises.writeFile('./joomla.asset.json', JSON.stringify(json, null, 2))
  console.log('File "joomla.asset.json" has been updated')
}

const updateTemplateXml = async () => {
  const file = await promises.readFile('./templateDetails.xml', 'utf8')
  const xml = file.replace(/<version>([0-9.]+)<\/version>/g, `<version>${pkg.version}</version>`)

  await promises.writeFile('./templateDetails.xml', xml)
  console.log('File "templateDetails.xml" has been updated')
}

const updateUpdateScript = async () => {
  const file = await promises.readFile('./updates/bettum_updates.xml', 'utf8')
  const xml = file.replace(/<version>([0-9.]+)<\/version>/g, `<version>${pkg.version}</version>`)

  await promises.writeFile('./updates/bettum_updates.xml', xml)
  console.log('File "bettum_updates.xml" has been updated')
}

const updateChangelog = async () => {
  const file = await promises.readFile('./CHANGELOG.md', 'utf8')
  const markdown = file.replace(/##\sWIP/g, `## ${pkg.version}`)

  await promises.writeFile('./CHANGELOG.md', markdown)
  console.log('File "CHANGELOG.md" has been updated')
}

updateJoomlaAssetJson()
updateTemplateXml()
updateUpdateScript()
updateChangelog()
