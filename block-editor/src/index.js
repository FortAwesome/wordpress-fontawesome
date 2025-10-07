import { registerBlockType } from '@wordpress/blocks'
import { Edit } from './edit'
import metadata from './block.json'
import { faBrandIcon } from './icons'
import { initialize as initializeRichTextIcon } from './richTextIcon'
import './index.css'
import example from './example'
import { config } from '@fortawesome/fontawesome-svg-core'
import deprecatedSaveV1 from './deprecated/deprecatedSaveV1'

config.autoAddCss = false
config.autoReplaceSvg = false

const disableRichTextIcons = !!window?.__FontAwesomeOfficialPlugin__?.disableRichTextIcons

if (!disableRichTextIcons) {
  initializeRichTextIcon()
}

// eslint-disable-next-line no-unused-vars
const { abstract: _abstract, ...attributesV1} = metadata?.attributes || {}

registerBlockType(metadata.name, {
  icon: faBrandIcon,
  edit: Edit,
  // No HTML will be saved with the block.
  // The back end render callback will render the icon on the front end.
  save: () => null,
  deprecated: [{
    attributes: attributesV1,
    save: deprecatedSaveV1,
  }],
  example
})
