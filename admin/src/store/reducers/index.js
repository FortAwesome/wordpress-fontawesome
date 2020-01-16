import size from 'lodash/size'
import omit from 'lodash/omit'
import { combineReducers } from 'redux'

export const ADMIN_TAB_SETTINGS = 'ADMIN_TAB_SETTINGS'
export const ADMIN_TAB_TROUBLESHOOT = 'ADMIN_TAB_TROUBLESHOOT'

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
    case 'SET_CONFLICT_DETECTION_SCANNER_END':
      if(action.success) {
        return {
          ...state,
          detectConflictsUntil: data.options.detectConflictsUntil
        }
      } else {
        return state
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
      return { ...state, isSubmitting: false, hasSubmitted: true, success, message }
    case 'ADD_PENDING_OPTION':
      return { ...state, hasSubmitted: false, success: false, message: '' }
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
      return coerceEmptyArrayToEmptyObject(state)
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

function unregisteredClients(state = {}, action = {}) {
  const { type, unregisteredClients = {} } = action

  switch(type) {
    case 'CONFLICT_DETECTION_SUBMIT_END':
      return { ...state, ...coerceEmptyArrayToEmptyObject(unregisteredClients)}
    default:
      return coerceEmptyArrayToEmptyObject(state)
  }
}

// Handles the state regarding what the conflict detection scanner finds when
// scanning and the submission of those results to the server.
function unregisteredClientDetectionStatus(
  state = {
    success: false,
    hasSubmitted: false,
    isSubmitting: false,
    countBeforeDetection: 0,
    countAfterDetection: 0,
    message: ''
  },
  action = {}) {

  const { type, success, message, countBeforeDetection } = action

  switch(type) {
    case 'CONFLICT_DETECTION_SUBMIT_START':
      return { ...state, isSubmitting: true, countBeforeDetection }
    case 'CONFLICT_DETECTION_SUBMIT_END':
      return {
        ...state,
        isSubmitting: false,
        hasSubmitted: true,
        success,
        message,
        countAfterDetection: size(action.unregisteredClients)
      }
    case 'CONFLICT_DETECTION_NONE_FOUND':
      return { ...state, isSubmitting: false, success: true }
    default:
      return state
  }
}

// Handles the state regarding the enabling or disabling of the conflict
// detection scanner overall.
function conflictDetectionScannerStatus(
  state = {
    isSubmitting: false,
    hasSubmitted: false,
    success: false,
    message: ''
  },
  action = {}) {

  const { type, success, message } = action

  switch(type) {
    case 'SET_CONFLICT_DETECTION_SCANNER_START':
      return { ...state, isSubmitting: true }
    case 'SET_CONFLICT_DETECTION_SCANNER_END':
      return { ...state, hasSubmitted: true, isSubmitting: false, success, message }
    default:
      return state
  }
}

function v3DeprecationWarningStatus(
  state = {
    isSubmitting: false,
    hasSubmitted: false,
    success: false,
    message: ''
  },
  action = {}) {
  const { type, success, message } = action

  switch(type) {
    case 'SNOOZE_V3DEPRECATION_WARNING_START':
      return { ...state, isSubmitting: true, hasSubmitted: true }
    case 'SNOOZE_V3DEPRECATION_WARNING_END':
      return { ...state, isSubmitting: false, success, message }
    default:
      return state
  }
}

function v3DeprecationWarning(state = {}, action = {}) {
  const { type, snooze = false } = action

  switch(type) {
    case 'SNOOZE_V3DEPRECATION_WARNING_END':
      return { ...state, snooze }
    default:
      return state
  }
}

function showConflictDetectionReporter(state = false, action = {}) {
  const { type } = action

  switch(type) {
    case 'SET_CONFLICT_DETECTION_SCANNER_END':
      return action.success
    case 'CONFLICT_DETECTION_TIMER_EXPIRED':
      return false
    default:
      return coerceBool(state)
  }
}

function activeAdminTab(state = ADMIN_TAB_SETTINGS, action = {}) {
  const { type, tab } = action

  switch(type) {
    case 'SET_ACTIVE_ADMIN_TAB':
      return tab
    default:
      return state
  }
}

function simple(state = {}, _action) { return state }

export default combineReducers({
  activeAdminTab,
  apiNonce: simple,
  apiUrl: simple,
  clientPreferences: coerceEmptyArrayToEmptyObject,
  conflictDetectionScannerStatus,
  onSettingsPage: coerceBool,
  options,
  optionsFormState,
  pendingOptionConflicts,
  pendingOptions,
  pluginVersion: simple,
  pluginVersionWarnings: simple,
  preferenceConflictDetection,
  preferenceConflicts,
  releaseProviderStatus: simple,
  releases: simple,
  settingsPageUrl: simple,
  showAdmin: coerceBool,
  showConflictDetectionReporter,
  unregisteredClientDetectionStatus,
  unregisteredClients,
  v3DeprecationWarning,
  v3DeprecationWarningStatus
})
