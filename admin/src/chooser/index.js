import get from 'lodash/get'

export function setupIconChooser() {
  console.log(`DEBUG: setupIconChooser`)

  if(window.tinymce) {
    console.log(`\tsetupClassicEditorIconChooser`)
  }

  if( get(window, 'wp.element') ) {
    console.log(`\tsetupGutenbergIconChooser`)
  }
}
