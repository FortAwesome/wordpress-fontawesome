import { registerBlockType } from '@wordpress/blocks'
import { Edit } from './edit'
import save from './save'
import metadata from './block.json'
import { faBrandIcon } from './icons'
import './richTextIcon'
import './index.css'
import example from './example'

registerBlockType(metadata.name, {
  icon: faBrandIcon,
  edit: Edit,
  save,
  example
})
