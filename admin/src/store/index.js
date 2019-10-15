import { createStore, applyMiddleware, compose } from 'redux'
import thunkMiddleware from 'redux-thunk'
import rootReducer from './reducers'

const initialData = window['__FontAwesomeOfficialPlugin__']

if(! initialData){
  console.error('Font Awesome plugin is broken: initial state data missing.')
}

const middleware = [ thunkMiddleware ]

const composeEnhancers = (
  process.env.NODE_ENV === 'development'
  && window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__
  ) || compose

const enhancer = composeEnhancers(
  applyMiddleware(...middleware)
)

export default createStore(
  rootReducer,
  initialData,
  enhancer
)