import { size, omit } from 'lodash'

const coerceBool = val => val === true || val === "1"

const coerceEmptyArrayToEmptyObject = val => size(val) === 0 ? {} : val

// TODO: add reducer for the clientPreferences that coerces their boolean options

function options(state = {}, _action = '') {
  return {
    ...state,
    usePro: coerceBool(state.usePro),
    v4compat: coerceBool(state.v4compat),
    svgPseudoElements: coerceBool(state.svgPseudoElements)
  }
}

function optionsFormState(state = { hasSubmitted: false, isSubmitting: false, submitSuccess: false, submitMessage: '' }, _action = '') {
  return  state
}

function pendingOptions(state = {}, action = {}) {
  const { type, change } = action
  if( ! change ) return state

  switch(type) {
    case 'ADD_PENDING_OPTION':
      return {...state, ...change}
    case 'RESET_PENDING_OPTION':
      const option = Object.keys(change)[0]
      return omit(state, option)
    case 'RESET_PENDING_OPTIONS':
      return {}
    default:
      return state
  }
}

function preferenceConflictDetection(
  state = {
    isChecking: false,
    hasChecked: false,
    success: false,
    message: ''
  },
  action = {}
  ){
  const { type, success, message } = action

  switch(type) {
    case 'PREFERENCE_CHECK_START':
      return { ...state, isChecking: true }
    case 'PREFERENCE_CHECK_END':
      return { ...state, isChecking: false, hasChecked: true, success, message }
    default:
      return state
  }
}

function pendingOptionConflicts(state = {}, action = {}) {
  const { type, detectedConflicts = {} } = action

  switch(type) {
    case 'PREFERENCE_CHECK_END':
      return { ...detectedConflicts }
    default:
      return state
  }
}

export default (state = {}, action = {}) => {
  return {
    ...state,
    showAdmin: coerceBool(state.showAdmin),
    showConflictDetectionReporter: coerceBool(state.showConflictDetectionReporter),
    onSettingsPage: coerceBool(state.onSettingsPage),
    preferenceConflicts: coerceEmptyArrayToEmptyObject(state.preferenceConflicts),
    unregisteredClients: coerceEmptyArrayToEmptyObject(state.unregisteredClients),
    clientPreferences: coerceEmptyArrayToEmptyObject(state.clientPreferences),
    options: options(state.options, action),
    pendingOptions: pendingOptions(state.pendingOptions, action),
    pendingOptionConflicts: pendingOptionConflicts(state.pendingOptionConflicts, action),
    preferenceConflictDetection: preferenceConflictDetection(state.preferenceConflictDetection, action),
    optionsFormState: optionsFormState(state.optionsFormState, action)
  }
}