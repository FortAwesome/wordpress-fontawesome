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
    iconChooserMediaButtonId: 'font-awesome-icon-chooser-media-button'
  }

  setupClassicEditor(params)

  classicEditorSetupComplete = true
}

export function setupIconChooser(initialParams) {
  const params = {
    ...initialParams,
    modalOpenEvent: new Event('fontAwesomeIconChooserOpen', { "bubbles": true, "cancelable": false })
  }

  /**
   * Tiny MCE loading time: In WordPress 5, it's straightforward to enqueue
   * this script with a script dependency of wp-tinymce. But that's not available
   * in WP 4, and there doesn't seem to be any way to ensure that the Tiny MCE
   * script has been loaded before this, other than to add a script after the
   * Tiny MCE scripts have been printed. So that's what we'll do.
   *
   * We'll expose a global function from here that the later loading script
   * can invoke to set up the Tiny MCE Icon Chooser integration.
   */
  if(window.tinymce) {
    // If tinymce is already loaded, we can set it up now.
    setupClassicEditorIconChooser(params)
  }

  if( get(window, 'wp.element') ) {
    setupBlockEditor(params)
  }

  // Returns that can be used to set up global hooks
  return {
    setupClassicEditorIconChooser: () => setupClassicEditorIconChooser(params)
  }
}
