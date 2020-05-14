const { Worker, isMainThread, parentPort } = require('worker_threads')
const { readdir, readFile, writeFile } = require('fs').promises
const { resolve } = require('path')
const Terser = require('terser')

async function* recursiveSearch(dir) {
  const dirents = await readdir(dir, { withFileTypes: true })
  for (const dirent of dirents) {
    const res = resolve(dir, dirent.name)
    if (dirent.isDirectory()) {
      yield* recursiveSearch(res)
    } else if (!res.includes('.min.js')) {
      yield res
    }
  }
}

async function processJs() {
  for await (const file of recursiveSearch(`${__dirname}/js/`)) {
    readFile(file, { encoding: 'utf8' })
      .then((data) => {
        writeFile(`${file.substr(0, file.lastIndexOf('.'))}.min.js`, Terser.minify(data, { output: { comments: false } }).code)
      })
  }
}

if (isMainThread) {
  const worker = new Worker(__filename)
  worker.postMessage('message')
} else {
  parentPort.once('message', () => {
    processJs()
  })
}
