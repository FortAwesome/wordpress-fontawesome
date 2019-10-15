import { size, omit } from 'lodash'

const coerceBool = val => val === true || val === "1"

const coerceEmptyArrayToEmptyObject = val => size(val) === 0 ? {} : val

// TODO: add reducer for the clientPreferences that coerces their boolean options

function options(state = {}, action = {}) {
  const { type, data } = action

  switch(type) {
    case 'OPTIONS_FORM_SUBMIT_END':
      const {
        options: {
          technology,
          usePro,
          v4compat,
          svgPseudoElements,
          detectConflictsUntil,
          version,
          blacklist
        }
      } = data

      return {
        technology,
        version,
        blacklist,
        detectConflictsUntil,
        usePro: coerceBool(usePro),
        v4compat: coerceBool(v4compat),
        svgPseudoElements: coerceBool(svgPseudoElements)
      }
    default:
      return state
  }
}

function optionsFormState(
  state = {
    hasSubmitted: false,
    isSubmitting: false,
    success: false,
    message: ''
  }, action = {}) {
  const { type, success, message } = action
  
  switch(type) {
    case 'OPTIONS_FORM_SUBMIT_START':
      return { ...state, isSubmitting: true }
    case 'OPTIONS_FORM_SUBMIT_END':
      return { ...state, isSubmitting: false, success, message }
    default:
      return state
  }
}

function pendingOptions(state = {}, action = {}) {
  const { type, change } = action

  switch(type) {
    case 'ADD_PENDING_OPTION':
      return {...state, ...change}
    case 'RESET_PENDING_OPTION':
      const option = Object.keys(change)[0]
      return omit(state, option)
    case 'RESET_PENDING_OPTIONS':
    case 'OPTIONS_FORM_SUBMIT_END':
      return {}
    default:
      return state
  }
}

function preferenceConflicts(state = {}, action = {}) {
  const { type } = action
  
  switch(type) {
    case 'OPTIONS_FORM_SUBMIT_END':
      const { data: { conflicts } } = action
      return coerceEmptyArrayToEmptyObject(conflicts)
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
    case 'OPTIONS_FORM_SUBMIT_END':
      return { ...state, isChecking: false, hasChecked: false, success: false, message: ''}
    default:
      return state
  }
}

function pendingOptionConflicts(state = {}, action = {}) {
  const { type, detectedConflicts = {} } = action

  switch(type) {
    case 'PREFERENCE_CHECK_END':
      return { ...detectedConflicts }
    case 'OPTIONS_FORM_SUBMIT_END':
      return {}
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
    unregisteredClients: coerceEmptyArrayToEmptyObject(state.unregisteredClients),
    clientPreferences: coerceEmptyArrayToEmptyObject(state.clientPreferences),
    preferenceConflicts: preferenceConflicts(state.preferenceConflicts),
    options: options(state.options, action),
    pendingOptions: pendingOptions(state.pendingOptions, action),
    pendingOptionConflicts: pendingOptionConflicts(state.pendingOptionConflicts, action),
    preferenceConflictDetection: preferenceConflictDetection(state.preferenceConflictDetection, action),
    optionsFormState: optionsFormState(state.optionsFormState, action)
  }
}