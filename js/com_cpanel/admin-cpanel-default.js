/**
* PLEASE DO NOT MODIFY THIS FILE. WORK ON THE ES6 VERSION.
* OTHERWISE YOUR CHANGES WILL BE REPLACED ON THE NEXT BUILD.
**/

/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
((window, document, Joomla) => {

  Joomla.unpublishModule = element => {
    // Get variables
    const baseUrl = 'index.php?option=com_modules&task=modules.unpublish&format=json';
    Joomla.request({
      url: `${baseUrl}&cid=${element.getAttribute('data-module-id')}`,
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      onSuccess: () => {
        const wrapper = element.closest('.module-wrapper');
        wrapper.parentNode.removeChild(wrapper);
        Joomla.renderMessages({
          message: [Joomla.JText._('COM_CPANEL_UNPUBLISH_MODULE_SUCCESS')]
        });
      },
      onError: () => {
        Joomla.renderMessages({
          error: [Joomla.JText._('COM_CPANEL_UNPUBLISH_MODULE_ERROR')]
        });
      }
    });
  };

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

    dragula([document.getElementById('cpanel-modules'), document.getElementById('card-columns')])
      .on('dragend', event => setModuleIds())

    const content = document.getElementById('content');
    if (content) {
      content.querySelectorAll('.unpublish-module').forEach(link => {
        link.addEventListener('click', event => Joomla.unpublishModule(event.target));
      });
    }

    document.removeEventListener('DOMContentLoaded', onBoot);
  };

  document.addEventListener('DOMContentLoaded', onBoot);

})(window, document, window.Joomla);