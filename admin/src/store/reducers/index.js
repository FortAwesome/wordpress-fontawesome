import size from 'lodash/size'
import omit from 'lodash/omit'
import get from 'lodash/get'
import { combineReducers } from 'redux'

export const ADMIN_TAB_SETTINGS = 'ADMIN_TAB_SETTINGS'
export const ADMIN_TAB_TROUBLESHOOT = 'ADMIN_TAB_TROUBLESHOOT'

const coerceBool = val => val === true || val === "1"

const coerceEmptyArrayToEmptyObject = val => size(val) === 0 ? {} : val

// TODO: add reducer for the clientPreferences that coerces their boolean options

export function blocklistSelector(state = {}) {
  const unregisteredClients = state.unregisteredClients || {}

  return Object.keys( unregisteredClients ).reduce( (acc, md5) => {
    if( get( unregisteredClients, [md5, 'blocked'], false ) ) {
      acc.push(md5)
    }
    return acc
  }, [])
}

export function options(state = {}, action = {}) {
  const { type, data } = action

  switch(type) {
    case 'OPTIONS_FORM_SUBMIT_END':
      if(! get(action, 'data.options')) {
        return state
      } else {
        const {
          options: {
            technology,
            usePro,
            v4Compat,
            pseudoElements,
            version,
            kitToken,
            apiToken
          }
        } = data

        return {
          technology,
          version,
          kitToken,
          apiToken,
          usePro: coerceBool(usePro),
          v4Compat: coerceBool(v4Compat),
          pseudoElements: coerceBool(pseudoElements)
        }
      }
    default:
      return state
  }
}

const OPTIONS_FORM_INITIAL_STATE = {
  hasSubmitted: false,
  isSubmitting: false,
  success: false,
  message: ''
}

function optionsFormState(
  state = OPTIONS_FORM_INITIAL_STATE, action = {}) {
  const { type, success, message } = action
  
  switch(type) {
    case 'OPTIONS_FORM_SUBMIT_START':
      return { ...state, isSubmitting: true }
    case 'OPTIONS_FORM_SUBMIT_END':
      return { ...state, isSubmitting: false, hasSubmitted: true, success, message }
    case 'OPTIONS_FORM_STATE_RESET':
    case 'CHOOSE_AWAY_FROM_KIT_CONFIG':
    case 'CHOOSE_INTO_KIT_CONFIG':
      return OPTIONS_FORM_INITIAL_STATE
    case 'ADD_PENDING_OPTION':
      return { ...state, hasSubmitted: false, success: false, message: '' }
    default:
      return state
  }
}

const INITIAL_STATE_BLOCKLIST_UPDATE_STATUS = {
  hasSubmitted: false,
  isSubmitting: false,
  pending: null,
  success: false,
  message: ''
}

function blocklistUpdateStatus( state = INITIAL_STATE_BLOCKLIST_UPDATE_STATUS, action = {} ) {
  const { type, success, message } = action
  
  switch(type) {
    case 'BLOCKLIST_UPDATE_RESET':
      return INITIAL_STATE_BLOCKLIST_UPDATE_STATUS
    case 'BLOCKLIST_UPDATE_START':
      return { ...state, isSubmitting: true }
    case 'BLOCKLIST_UPDATE_END':
      return { ...state, isSubmitting: false, pending: null, hasSubmitted: true, success, message }
    case 'UPDATE_PENDING_BLOCKLIST':
      if(Array.isArray(action.data) || null === action.data) {
        return {
          ...state,
          hasSubmitted: false,
          pending: action.data,
          success: false,
          message: ''
        }
      } else {
        return state
      }
    default:
      return state
  }
}

const INITIAL_STATE_UNREGISTERED_CLIENTS_DELETION_STATUS = {
  hasSubmitted: false,
  isSubmitting: false,
  pending: [],
  success: false,
  message: ''
}

function unregisteredClientsDeletionStatus(
  state = INITIAL_STATE_UNREGISTERED_CLIENTS_DELETION_STATUS,
  action = {} ) {
  const { type, success, message } = action
  
  switch(type) {
    case 'DELETE_UNREGISTERED_CLIENTS_RESET':
      return INITIAL_STATE_UNREGISTERED_CLIENTS_DELETION_STATUS
    case 'DELETE_UNREGISTERED_CLIENTS_START':
      return { ...state, hasSubmitted: false, success: false, isSubmitting: true }
    case 'DELETE_UNREGISTERED_CLIENTS_END':
      return { ...state, isSubmitting: false, pending: [], hasSubmitted: true, success, message }
    case 'UPDATE_PENDING_UNREGISTERED_CLIENTS_FOR_DELETION':
      if( Array.isArray(action.data) ) {
        return { ...state, hasSubmitted: false, pending: action.data, success: false, message: '' }
      } else {
        return state
      }
    default:
      return state
  }
}

function pendingOptions(state = {}, action = {}) {
  const { type, change, activeKitToken, concreteVersion } = action

  switch(type) {
    case 'ADD_PENDING_OPTION':
      return {...state, ...change}
    case 'RESET_PENDING_OPTION':
      const option = Object.keys(change)[0]
      return omit(state, option)
    case 'CHOOSE_AWAY_FROM_KIT_CONFIG':
      return !!activeKitToken ? { kitToken: null, version: concreteVersion } : {}
    case 'CHOOSE_INTO_KIT_CONFIG':
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
      if ( ! action.success ) {
        return state
      }

      const conflicts = get(action, 'data.conflicts')

      if(!! conflicts) {
        return coerceEmptyArrayToEmptyObject(conflicts)
      } else {
        return coerceEmptyArrayToEmptyObject(state)
      }
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

function kitsQueryStatus(
  state = {
    success: false,
    hasSubmitted: false,
    isSubmitting: false,
    message: ''
  },
  action = {}) {
  const { type, success, message } = action

  switch(type) {
    case 'KITS_QUERY_START':
      return { ...state, isSubmitting: true }
    case 'KITS_QUERY_END':
      return { ...state, isSubmitting: false, hasSubmitted: true, success, message }
    default:
      return state
  }
}

function kits( state = [], action = {} ) {
  const { type, data, success } = action
  switch(type) {
    case 'KITS_QUERY_END':
      if(success) {
        return get(data, 'me.kits', [])
      } else {
        return state
      }
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
    case 'CHOOSE_AWAY_FROM_KIT_CONFIG':
    case 'CHOOSE_INTO_KIT_CONFIG':
      return {}
    default:
      return state
  }
}

function detectConflictsUntil( state = 0, action = {} ) {
  const { type, data } = action
  const intValue = parseInt( get(data, 'detectConflictsUntil') )

  switch(type) {
    case 'ENABLE_CONFLICT_DETECTION_SCANNER_END':
    case 'DISABLE_CONFLICT_DETECTION_SCANNER_END':
      if(action.success && null !== data ) {
        return isNaN(intValue) ? 0 : intValue
      } else {
        return state
      }
    default:
      const initialIntValue = parseInt( state )
      return isNaN(initialIntValue) ? 0 : initialIntValue
  }
}

function unregisteredClients( state = {}, action = {} ) {
  const { type, data } = action

  switch(type) {
    case 'CONFLICT_DETECTION_SUBMIT_END':
      if( action.success && null !== data ) {
        return coerceEmptyArrayToEmptyObject(data)
      } else {
        return coerceEmptyArrayToEmptyObject(state)
      }
    case 'BLOCKLIST_UPDATE_END':
      if(action.success && Array.isArray(data)) {
        const updatedState = Object.keys(state).reduce(
          (acc, md5) => {
            acc[md5].blocked = !!~data.indexOf(md5)
            return acc
          },
          Object.assign({}, state) // operate on a copy
        )
        return coerceEmptyArrayToEmptyObject(updatedState)
      } else {
        return coerceEmptyArrayToEmptyObject(state)
      }
    case 'DELETE_UNREGISTERED_CLIENTS_END':
      if(action.success && !!data) {
        return data
      } else {
        return coerceEmptyArrayToEmptyObject(state)
      }
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
    unregisteredClientsBeforeDetection: [],
    recentConflictsDetected: {},
    message: ''
  },
  action = {}) {

  const { type, success, message, unregisteredClientsBeforeDetection, recentConflictsDetected } = action

  switch(type) {
    case 'CONFLICT_DETECTION_SUBMIT_START':
      return { ...state, isSubmitting: true, unregisteredClientsBeforeDetection, recentConflictsDetected }
    case 'CONFLICT_DETECTION_SUBMIT_END':
      return {
        ...state,
        isSubmitting: false,
        hasSubmitted: true,
        success,
        message
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
    case 'ENABLE_CONFLICT_DETECTION_SCANNER_START':
    case 'DISABLE_CONFLICT_DETECTION_SCANNER_START':
      return { ...state, hasSubmitted: false, success: false, isSubmitting: true }
    case 'ENABLE_CONFLICT_DETECTION_SCANNER_END':
    case 'DISABLE_CONFLICT_DETECTION_SCANNER_END':
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
    case 'ENABLE_CONFLICT_DETECTION_SCANNER_END':
      return action.success
    case 'DISABLE_CONFLICT_DETECTION_SCANNER_END':
      // If we failed trying to disable the scanner, then it should remain
      // visible to present the error state. If we succeeded, then we could
      // stop showing it.
      return ! action.success
    case 'CONFLICT_DETECTION_TIMER_EXPIRED':
      return false
    default:
      return coerceBool(state)
  }
}

function userAttemptedToStopScanner(state = false, action = {}) {
  const { type } = action

  switch(type) {
    case 'USER_STOP_SCANNER':
      return true
    case 'ENABLE_CONFLICT_DETECTION_SCANNER_START':
    case 'ENABLE_CONFLICT_DETECTION_SCANNER_END':
      return false
    default:
      return state
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
  blocklistUpdateStatus,
  clientPreferences: coerceEmptyArrayToEmptyObject,
  conflictDetectionScannerStatus,
  detectConflictsUntil,
  kits,
  kitsQueryStatus,
  onSettingsPage: coerceBool,
  options,
  optionsFormState,
  pendingOptionConflicts,
  pendingOptions,
  pluginVersion: simple,
  preferenceConflictDetection,
  preferenceConflicts,
  restApiNamespace: simple,
  rootUrl: simple,
  mainCdnAssetUrl: simple,
  mainCdnAssetIntegrity: simple,
  enableIconChooser: coerceBool,
  releases: simple,
  settingsPageUrl: simple,
  showAdmin: coerceBool,
  showConflictDetectionReporter,
  unregisteredClientDetectionStatus,
  unregisteredClients,
  unregisteredClientsDeletionStatus, 
  userAttemptedToStopScanner,
  v3DeprecationWarning,
  v3DeprecationWarningStatus,
  webpackPublicPath: simple,
})
