import get from 'lodash/get'

let classicEditorSetupComplete = false

function setupGutenbergIconChooser() {
    console.log(`\tsetupGutenbergIconChooser`)
}

function setupClassicEditorIconChooser() {
  // We only want to do this once.
  if(classicEditorSetupComplete) return
  if(!window.tinymce) return

  console.log(`\tsetupClassicEditorIconChooser`)

  classicEditorSetupComplete = true
}

export function setupIconChooser() {
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
    setupClassicEditorIconChooser()
  }

  // More likely, Tiny MCE will be loaded later, so we'll expose the global set up function.
  window['__FontAwesomeOfficialPlugin__setupClassicEditorIconChooser'] = setupClassicEditorIconChooser

  if( get(window, 'wp.element') ) {
    setupGutenbergIconChooser()
  }
}
