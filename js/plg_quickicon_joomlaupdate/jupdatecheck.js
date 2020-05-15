/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/**
 * Ajax call to get the update status of Joomla
 */
((document, Joomla) => {
  'use strict';

  const createUpdateModal = (version) => {
    const html = `<div id="joomlaUpdateModal" class="modal hide fade in" aria-modal="true" role="dialog">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">${Joomla.Text._('PLG_QUICKICON_JOOMLAUPDATE_UPDATEFOUND').replace('%s', `<span class="badge badge-danger"> \u200E ${version}</span>`)}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-footer">
            <a href="index.php?option=com_joomlaupdate" class="btn btn-success">Update Now!</a>
          </div>
        </div>
      </div>
    </div>`;
    const container = document.createElement('div');
    container.innerHTML = html;

    document.body.append(container);
  }

  const checkForJoomlaUpdates = () => {
    if (Joomla.getOptions('js-extensions-update')) {
      const options = Joomla.getOptions('js-joomla-update');

      const update = (type, text) => {
        const link = document.getElementById('plg_quickicon_joomlaupdate');
        const linkSpans = [].slice.call(link.querySelectorAll('span.j-links-link'));

        if (link) {
          link.classList.add(type);
        }

        if (linkSpans.length) {
          linkSpans.forEach(span => {
            span.innerHTML = text;
          });
        }
      };

      Joomla.request({
        url: options.ajaxUrl,
        method: 'GET',
        data: '',
        perform: true,
        onSuccess: response => {
          const updateInfoList = JSON.parse(response);

          if (Array.isArray(updateInfoList)) {
            if (updateInfoList.length === 0) {
              // No updates
              update('success', Joomla.Text._('PLG_QUICKICON_JOOMLAUPDATE_UPTODATE'));
            } else {
              const updateInfo = updateInfoList.shift();

              if (updateInfo.version !== options.version) {
                update('danger', Joomla.Text._('PLG_QUICKICON_JOOMLAUPDATE_UPDATEFOUND').replace('%s', `<span class="badge badge-light"> \u200E ${updateInfo.version}</span>`));
                createUpdateModal(updateInfo.version);
              } else {
                update('success', Joomla.Text._('PLG_QUICKICON_JOOMLAUPDATE_UPTODATE'));
              }
            }
          } else {
            // An error occurred
            update('danger', Joomla.Text._('PLG_QUICKICON_JOOMLAUPDATE_ERROR'));
          }
        },
        onError: () => {
          // An error occurred
          update('danger', Joomla.Text._('PLG_QUICKICON_JOOMLAUPDATE_ERROR'));
        }
      });
    }
  };

  const onBoot = () => {
    if (!Joomla || typeof Joomla.getOptions !== 'function' || !Joomla.getOptions('js-joomla-update')) {
      throw new Error('Script is not properly initialised');
    }

    setTimeout(checkForJoomlaUpdates, 2000); // Cleanup

    document.removeEventListener('DOMContentLoaded', onBoot);
  }; // Initialize


  document.addEventListener('DOMContentLoaded', onBoot);
})(document, Joomla);