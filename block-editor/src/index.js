import { registerBlockType } from "@wordpress/blocks";
import { createEditComponent, Edit } from "./edit";
import save from "./save";
import metadata from "./block.json";
import blockIcon from './blockIcon.js';
import './inlineSvgFormatType.js';

registerBlockType(metadata.name, {
  icon: blockIcon,
  edit: Edit,
  save,
});
