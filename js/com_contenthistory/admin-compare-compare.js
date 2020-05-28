/**
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
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
    const diff = window.Diff.diffWords(original.innerHTML, changed.innerHTML)
    const fragment = document.createDocumentFragment()
    diff.forEach(part => {
      let node

      if (part.added) {
        node = document.createElement('ins')
      } else if (part.removed) {
        node = document.createElement('del')
      } else {
        node = document.createElement('span')
      }

      node.appendChild(document.createTextNode(decodeHtml(part.value)))
      fragment.appendChild(node)
    })
    display.appendChild(fragment)
  }

  const onBoot = () => {
    const diffs = document.querySelectorAll('.original')
    diffs.forEach(fragment => {
      compare(fragment, fragment.nextElementSibling)
    })

    document.removeEventListener('DOMContentLoaded', onBoot)
  }

  document.addEventListener('DOMContentLoaded', onBoot)
})()
