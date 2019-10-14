import { createStore, applyMiddleware, compose } from 'redux'
import thunkMiddleware from 'redux-thunk'
import rootReducer from './reducers'

const initialData = window['__FontAwesomeOfficialPlugin__'] || {}

// TODO: Handle the error case where we don't have valid initialData

export default createStore(
  rootReducer,
  initialData,
  compose(
    applyMiddleware(thunkMiddleware),
    window.__REDUX_DEVTOOLS_EXTENSION__ && window.__REDUX_DEVTOOLS_EXTENSION__()
  )
)