import { registerBlockType } from '@wordpress/blocks'
import { Edit } from './edit'
import save from './save'
import metadata from './block.json'
import { faBrandIcon } from './icons'
import './richTextIcon'
import './index.css'
import example from './example'
import { config } from '@fortawesome/fontawesome-svg-core'
config.autoAddCss = false
config.autoReplaceSvg = false

registerBlockType(metadata.name, {
  icon: faBrandIcon,
  edit: Edit,
  save,
  example
})
