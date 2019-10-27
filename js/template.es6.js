/**
 * @copyright  Copyright (C) 2019 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

(() => {
  'use strict';

  document.addEventListener('DOMContentLoaded', () => {

    // Navbar
    // const menu = document.getElementById('menu');
    // document.querySelectorAll('#menu > .nav-item').forEach((item) => {
      // const observer = new MutationObserver((mutation) => {
        // if (Array.from(mutation[0].target.classList).includes('show')) {
          // menu.classList.add('navbar-hover');
		// } else {
          // menu.classList.remove('navbar-hover');
		// }
      // });

      // observer.observe(item, {
        // attributes: true,
        // attributeFilter: ['class']
      // });
    // });
	
    const cpanelAccordion = document.getElementById('cpanelAccordion');
    if (cpanelAccordion) {
      const firstCpanelAccordion = cpanelAccordion.querySelector('.card');
      firstCpanelAccordion.querySelectorAll('[aria-expanded]').forEach((aria) => {
        aria.setAttribute('aria-expanded', true);
      });

      firstCpanelAccordion.querySelector('.collapse').classList.add('show');
    }

  });

})();
