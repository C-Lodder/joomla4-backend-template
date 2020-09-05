window.customElements.define('joomla-alert', class JoomlaAlertElement extends HTMLElement {
  /* Attributes to monitor */
  static get observedAttributes() { return ['type', 'role', 'dismiss'] }

  get type() { return this.getAttribute('type') }

  set type(value) { return this.setAttribute('type', value) }

  get role() { return this.getAttribute('role') }

  set role(value) { return this.setAttribute('role', value) }

  get dismiss() { return this.getAttribute('dismiss') }

  get autodismiss() { return this.getAttribute('auto-dismiss') }

  /* Lifecycle, element appended to the DOM */
  connectedCallback() {
    this.classList.add('joomla-alert--show')

    // Default to info
    if (!this.type || ['info', 'warning', 'danger', 'success'].indexOf(this.type) === -1) {
      this.setAttribute('type', 'info')
    }
    // Default to alert
    if (this.type === 'success') {
      this.setAttribute('role', 'status')
    } else if (['alert', 'alertdialog'].indexOf(this.role) === -1) {
      this.setAttribute('role', 'alert')
    }

    // Append button
    if ((this.hasAttribute('dismiss')
      || !this.querySelector('button.joomla-alert--close') && !this.querySelector('button.joomla-alert-button--close'))) {
      this.appendCloseButton()
    }

    if ((this.hasAttribute('auto-dismiss') || this.hasAttribute('dismiss')) && this.type === 'success') {
      this.autoDismiss()
    }

    this.dispatchCustomEvent('joomla.alert.show')
  }

  /* Lifecycle, element removed from the DOM */
  disconnectedCallback() {
    this.removeEventListener('joomla.alert.show', this)
    this.removeEventListener('joomla.alert.close', this)
    this.removeEventListener('joomla.alert.closed', this)

    if (this.firstChild.tagName && this.firstChild.tagName.toLowerCase() === 'button') {
      this.firstChild.removeEventListener('click', this)
    }
  }

  /* Method to close the alert */
  close() {
    this.dispatchCustomEvent('joomla.alert.close')
    this.addEventListener('transitionend', () => {
      this.dispatchCustomEvent('joomla.alert.closed')
      this.remove()
    }, false)
    this.classList.remove('joomla-alert--show')
  }

  /* Method to dispatch events */
  dispatchCustomEvent(eventName) {
    const OriginalCustomEvent = new CustomEvent(eventName)
    OriginalCustomEvent.relatedTarget = this
    this.dispatchEvent(OriginalCustomEvent)
    this.removeEventListener(eventName, this)
  }

  /* Method to create the close button */
  appendCloseButton() {
    if (this.querySelector('button.joomla-alert--close') || this.querySelector('button.joomla-alert-button--close')) {
      return
    }

    if (this.hasAttribute('dismiss')) {
      const closeButton = document.createElement('button')
      closeButton.classList.add('joomla-alert--close')
      closeButton.innerHTML = '<span aria-hidden="true">&times</span>'
      closeButton.setAttribute('aria-label', this.getText('JCLOSE', 'Close'))

      if (this.firstChild) {
        this.insertBefore(closeButton, this.firstChild)
      } else {
        this.appendChild(closeButton)
      }

      /* Add the required listener */
      closeButton.addEventListener('click', () => {
        this.close()
      })
    }
  }

  /* Method to auto-dismiss */
  autoDismiss() {
    window.setTimeout(() => {
      this.close()
    }, parseInt(this.getAttribute('auto-dismiss'), 10) ? this.getAttribute('auto-dismiss') : 5000)
  }

  /* Method to get the translated text */
  getText(str, fallback) {
    // TODO: Remove coupling to Joomla CMS Core JS here
    /* eslint-disable-next-line no-undef */
    return (window.Joomla && Joomla.JText && Joomla.JText._ && typeof Joomla.JText._ === 'function' && Joomla.JText._(str)) ? Joomla.JText._(str) : fallback
  }
})
