/**
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document) => {
  'use strict'

  // Navbar
  const menu = document.getElementById('menu')
  document.querySelectorAll('#menu > .nav-item').forEach((item) => {
    const observer = new MutationObserver((mutation) => {
      if (Array.from(mutation[0].target.classList).includes('show')) {
        menu.classList.add('navbar-hover')
      } else {
        menu.classList.remove('navbar-hover')
      }
    })

    observer.observe(item, {
      attributes: true,
      attributeFilter: ['class']
    })
  })

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
