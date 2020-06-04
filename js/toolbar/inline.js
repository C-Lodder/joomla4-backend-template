/**
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document) => {
  'use strict'

  const saveGroup = document.getElementById('toolbar-dropdown-save-group')
  if (saveGroup) {
    const toolbar = saveGroup.parentNode
    // Remove the dropdown toggle
    saveGroup.querySelector('.dropdown-toggle-split').remove()

    // Move the dropdown items outside
    saveGroup.querySelectorAll('joomla-toolbar-button').forEach((item) => {
      const button = item.querySelector('button')
      button.classList.remove('dropdown-item')
      button.classList.add('btn', 'btn-success')

      saveGroup.parentNode.insertBefore(item, saveGroup.nextSibling)
    })

    saveGroup.remove()
  }

})(document)
