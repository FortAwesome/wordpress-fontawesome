import set from "lodash-es/set";
import get from "lodash-es/get";
import { GLOBAL_KEY } from "../../admin/src/constants";
import prepareQueryHandler from "./handleQuery.js";
import getUrlText from "./getUrlText.js";
import configureIconChooserModal from "./IconChooserModal.js";

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
