/**
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document) => {
  'use strict'

  const sidebar = document.getElementById('bettum-sidebar')

  if (sidebar) {
    // Toggle the sidebar
    const navbarToggle = document.getElementById('navbar-toggler')
    navbarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('show')
      if (sidebar.classList.contains('show')) {
        navbarToggle.setAttribute('aria-expanded', true)
      } else {
        navbarToggle.setAttribute('aria-expanded', false)
      }
    })

    // Keep the active dropdown shown on page load
    const currentUrl = window.location.href.toLowerCase()
    sidebar.querySelectorAll('.sidebar-item').forEach(link => {
      if (currentUrl === link.href) {
        link.setAttribute('aria-current', 'page')

        if (!link.hasAttribute('data-toggle')) {
          const firstLevel = link.closest('.collapse-level-1')
          const secondLevel = link.closest('.collapse-level-2')
          if (firstLevel) {
            firstLevel.previousElementSibling.setAttribute('aria-expanded', true)
            firstLevel.classList.add('show')
          }
          if (secondLevel) {
            secondLevel.previousElementSibling.setAttribute('aria-expanded', true)
            secondLevel.classList.add('show')
          }
        }
      }
    })
  }

})(document)
