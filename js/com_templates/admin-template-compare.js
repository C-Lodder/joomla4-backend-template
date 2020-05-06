/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later see LICENSE.txt
 */

(() => {
  'use strict'

  // This method is used to decode HTML entities
  const decodeHtml = html => {
    const textarea = document.createElement('textarea')
    textarea.innerHTML = html
    return textarea.value
  }

  const compare = (original, changed) => {
    const display = changed.nextElementSibling
    const diff = Diff.diffLines(original.innerHTML, changed.innerHTML)
    const fragment = document.createDocumentFragment()
    diff.forEach(part => {
      const pre = document.createElement('pre')

      if (part.added) {
        pre.classList.add('added')
      } else if (part.removed) {
        pre.classList.add('removed')
      }

      pre.appendChild(document.createTextNode(decodeHtml(part.value)))
      fragment.appendChild(pre)
    })
    display.appendChild(fragment)
  }

  const onBoot = () => {
    const original = document.getElementById('original')
    compare(original, original.nextElementSibling)

    document.removeEventListener('DOMContentLoaded', onBoot)
  }

  document.addEventListener('DOMContentLoaded', onBoot)
})()
