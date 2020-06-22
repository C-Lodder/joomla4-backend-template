/**
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((Joomla) => {
  'use strict'

  const hideA11ySettings = () => {
    const settings = document.getElementById('fieldset-accessibility')
    if (settings) {
      const div = settings.querySelector('div')
      // Remove the settings from the DOM
      div.remove()

      // Build the alert
      const alert = document.createElement('div')
      alert.classList.add('alert', 'alert-info')
      alert.innerText = 'Accessibility settings should be changed in your operating system or browser settings.'

      // Append the alert
      settings.append(alert)
    }
  }

  document.addEventListener('DOMContentLoaded', () => {
    Joomla.twoFactorMethodChange = () => {
      const method = document.getElementById('jform_twofactor_method')
      if (method) {
        const selectedPane = `com_users_twofactor_${method.value}`
        const twoFactorForms = document.querySelectorAll('#com_users_twofactor_forms_container > div')
        twoFactorForms.forEach((value) => {
          const { id } = value
          if (id !== selectedPane) {
            document.getElementById(id).classList.add('hidden')
          } else {
            document.getElementById(id).classList.remove('hidden')
          }
        })
      }
    }

    hideA11ySettings()
  })
})(Joomla)
