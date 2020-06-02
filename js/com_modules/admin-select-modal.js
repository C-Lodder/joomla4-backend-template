/**
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document) => {
  'use strict'

  document.addEventListener('DOMContentLoaded', () => {
    const newModuleList = document.getElementById('new-modules-list')
    const selectLinks = newModuleList.querySelectorAll('.select-link')

    selectLinks.forEach((link) => {
      link.addEventListener('click', ({ currentTarget, target }) => {
        let targetElem = currentTarget

        // There is some bug with events in iframe where currentTarget is "null"
        // => prevent this here by bubble up
        if (!targetElem) {
          targetElem = target

          if (targetElem && !targetElem.classList.contains('select-link')) {
            targetElem = targetElem.parentNode
          }
        }

        const functionName = targetElem.getAttribute('data-function')

        if (functionName && typeof window.parent[functionName] === 'function') {
          window.parent[functionName](targetElem)
        }
      })
    })

    document.getElementById('new-modules-list-search').addEventListener('input', ({ target }) => {
      newModuleList.querySelectorAll('.name').forEach((name) => {
        const item = name.closest('li')
        if (!name.innerText.toLowerCase().includes(target.value.toLowerCase())) {
          item.classList.add('d-none')
          item.classList.remove('d-flex')
        } else {
          item.classList.add('d-flex')
          item.classList.remove('d-none')
        }
      })
    })
  })
})(document)
