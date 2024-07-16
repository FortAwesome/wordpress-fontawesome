import { registerBlockType } from "@wordpress/blocks";
import { createEditComponent, Edit } from "./edit";
import save from "./save";
import metadata from "./block.json";
import { faBrandIcon } from './icons';
import './richTextIcon';

registerBlockType(metadata.name, {
  icon: faBrandIcon,
  edit: Edit,
  save,
});
