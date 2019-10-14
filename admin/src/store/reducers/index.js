import { size } from 'lodash'

const coerceBool = val => val === true || val === "1"

const coerceEmptyArrayToEmptyObject = val => size(val) === 0 ? {} : val

function options(state = {}, _action = '') {
  return {
    ...state,
    usePro: coerceBool(state.usePro),
    v4compat: coerceBool(state.v4compat),
    svgPseudoElements: coerceBool(state.svgPseudoElements)
  }
}

export default (state = {}, action = '') => {
  return {
    ...state,
    showAdmin: coerceBool(state.showAdmin),
    showConflictDetectionReporter: coerceBool(state.showConflictDetectionReporter),
    onSettingsPage: coerceBool(state.onSettingsPage),
    preferenceConflicts: coerceEmptyArrayToEmptyObject(state.preferenceConflicts),
    unregisteredClients: coerceEmptyArrayToEmptyObject(state.unregisteredClients),
    clientPreferences: coerceEmptyArrayToEmptyObject(state.clientPreferences),
    options: options(state.options, action)
  }
}