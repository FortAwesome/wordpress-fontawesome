import { registerBlockType } from "@wordpress/blocks";
import { createEditComponent, Edit } from "./edit";
import save from "./save";
import metadata from "./block.json";
import { blockIcon } from '../../admin/src/chooser/blockEditor';

registerBlockType(metadata.name, {
  icon: blockIcon,
  edit: Edit,
  save,
});
