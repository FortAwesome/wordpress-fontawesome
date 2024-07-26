import { registerBlockType } from '@wordpress/blocks'
import save from './save'
import metadata from './block.json'
import { faBrandIcon } from './icons'
import './richTextIcon'
import './index.css'
import { Edit } from './edit'

registerBlockType(metadata.name, {
  icon: faBrandIcon,
  edit: Edit,
  save
})
