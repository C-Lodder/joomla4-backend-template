/**
 * @copyright  Copyright (C) 2020 Charlie Lodder. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

((document, Joomla) => {
  'use strict'

  Joomla.unpublishModule = element => {
    // Get variables
    const baseUrl = 'index.php?option=com_modules&task=modules.unpublish&format=json'
    Joomla.request({
      url: `${baseUrl}&cid=${element.getAttribute('data-module-id')}`,
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      onSuccess: () => {
        const wrapper = element.closest('.module-wrapper')
        wrapper.parentNode.removeChild(wrapper)
        Joomla.renderMessages({
          message: [Joomla.JText._('COM_CPANEL_UNPUBLISH_MODULE_SUCCESS')]
        })
      },
      onError: () => {
        Joomla.renderMessages({
          error: [Joomla.JText._('COM_CPANEL_UNPUBLISH_MODULE_ERROR')]
        })
      }
    })
  }

  const onBoot = () => {
    const content = document.getElementById('content')
    if (content) {
      content.querySelectorAll('.unpublish-module').forEach(link => {
        link.addEventListener('click', ({ target }) => Joomla.unpublishModule(target))
      })
    }

    document.removeEventListener('DOMContentLoaded', onBoot)
  }

  document.addEventListener('DOMContentLoaded', onBoot)

})(document, Joomla)