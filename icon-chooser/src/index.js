import { set, get } from "lodash";
import { GLOBAL_KEY } from "../../admin/src/constants";
import prepareQueryHandler from "./handleQuery.js";
import getUrlText from "./getUrlText.js";
import configureIconChooserModal from "./IconChooserModal.js";

// As of February 2025, only the official Font Awesome WordPress plugin
// is licensed to enable SVG Embedding for all Font Awesome plans.
// See https://fontawesome.com/plans and https://fontawesome.com/support
window["__FA_SVG_EMBED__"] = () => true;

const initialData = window[GLOBAL_KEY];
const kitToken = get(initialData, "options.kitToken");
const version = get(initialData, "options.version");
const pro = get(initialData, "options.usePro");

const params = {
  ...initialData,
  kitToken,
  version,
  getUrlText,
  pro,
};

params.handleQuery = prepareQueryHandler(params);

const IconChooserModal = configureIconChooserModal(params);

set(window, [GLOBAL_KEY, "iconChooser"], {
  IconChooserModal,
});
