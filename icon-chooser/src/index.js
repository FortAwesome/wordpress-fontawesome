import set from "lodash/set";
import get from "lodash/get";
import { GLOBAL_KEY } from "../../admin/src/constants"
import configureQueryHandler from "./handleQuery.js"
import getUrlText from "./getUrlText.js"
import configureIconChooserModal from "./IconChooserModal.js"

const modalOpenEvent = new Event("fontAwesomeIconChooserOpen", {
  "bubbles": true,
  "cancelable": false,
});

window["__FontAwesomeOfficialPlugin__openIconChooserModal"] = () => {
  document.dispatchEvent(params.modalOpenEvent);
};

const initialData = window[GLOBAL_KEY]
const kitToken = get(initialData, 'options.kitToken')
const version = get(initialData, 'options.version')
const pro = get(initialData, 'options.usePro')

const params = {
  ...initialData,
  kitToken,
  version,
  getUrlText,
  pro,
  modalOpenEvent,
}

params.handleQuery = configureQueryHandler(params) 

const IconChooserModal = configureIconChooserModal(params)

set(window, [GLOBAL_KEY, 'iconChooser'], {
  modalOpenEvent,
  IconChooserModal
});
