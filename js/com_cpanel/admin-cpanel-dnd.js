/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document) => {
  'use strict'

  const setModuleIds = () => {
    const modules = []
    document.querySelectorAll('[data-cpanel-module-id]').forEach(module => {
      const obj = {}
      obj.id = module.getAttribute('data-cpanel-module-id')
      obj.cardColumn = module.parentNode.id === 'card-columns' ? true : false
      modules.push(obj)
    })
    localStorage.setItem('cpanel-modules', JSON.stringify(modules))
  }

  const renderModules = () => {
    const cpanelModules = document.getElementById('cpanel-modules')
    const cardColumns = document.getElementById('card-columns')

    const moduleIds = localStorage.getItem('cpanel-modules')
    if (moduleIds !== null) {
      JSON.parse(moduleIds).forEach(module => {
        const element = document.querySelector(`[data-cpanel-module-id="${module.id}"]`)
        if (module.cardColumn) {
          cardColumns.append(element)
        } else {
          cpanelModules.append(element)
        }
        element.classList.remove('d-none')
      })
    } else {
      document.querySelectorAll('[data-cpanel-module-id]').forEach(module => {
        module.classList.remove('d-none')
      })
    }
  }

  const onBoot = () => {
    renderModules()

    dragula([document.getElementById('cpanel-modules'), document.getElementById('card-columns')], {
      moves: (el, container, { classList }) => classList.contains('handle')
    }).on('dragend', event => setModuleIds())

    document.removeEventListener('DOMContentLoaded', onBoot)
  }

  document.addEventListener('DOMContentLoaded', onBoot)

})(document)