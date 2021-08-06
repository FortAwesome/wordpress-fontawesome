import get from 'lodash/get'
import { setupBlockEditor } from './blockEditor'
import { setupClassicEditor } from './classicEditor'

let classicEditorSetupComplete = false

function setupClassicEditorIconChooser(initialParams) {
  // We only want to do this once.
  if(classicEditorSetupComplete) return
  if(!window.tinymce) return

  const params = {
    ...initialParams,
    iconChooserContainerId: 'font-awesome-icon-chooser-container',
    iconChooserMediaButtonClass: 'font-awesome-icon-chooser-media-button'
  }

  setupClassicEditor(params)

  classicEditorSetupComplete = true
}

export function setupIconChooser(initialParams) {
  const params = {
    ...initialParams,
    modalOpenEvent: new Event('fontAwesomeIconChooserOpen', { "bubbles": true, "cancelable": false })
  }

  if( get(window, 'wp.element') ) {
    setupBlockEditor(params)
  }

  /**
   * Tiny MCE loading time: In WordPress 5, it's straightforward to enqueue
   * this script with a script dependency of wp-tinymce. But that's not available
   * in WP 4, and there doesn't seem to be any way to ensure that the Tiny MCE
   * script has been loaded before this, other than to add a script after the
   * Tiny MCE scripts have been printed.
   *
   * So what we'll do instead is simply export this function that can be exposed
   * as a global function, and in our back end PHP code, we'll add an inline script
   * to invoke that global for tinyMCE setup if and when it is necessary.
   */
  return {
    setupClassicEditorIconChooser: () => setupClassicEditorIconChooser(params)
  }
}
