/**
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document) => {
  'use strict'

  // Sidebar
  const navbarToggle = document.getElementById('navbar-toggler')
  const sidebar = document.getElementById('bettum-sidebar')
  if (sidebar) {
    navbarToggle.addEventListener('click', () => {
      sidebar.classList.toggle('show')
      if (sidebar.classList.contains('show')) {
        navbarToggle.setAttribute('aria-expanded', true)
      } else {
        navbarToggle.setAttribute('aria-expanded', false)
      }
    })
  }

})(document)
