import { createStore as reduxCreateStore, applyMiddleware, compose } from 'redux'
import { thunk } from 'redux-thunk'
import rootReducer from './reducers'

const middleware = [ thunk ]

const composeEnhancers = (
  process.env.NODE_ENV === 'development'
  && window.__REDUX_DEVTOOLS_EXTENSION_COMPOSE__
  ) || compose

const enhancer = composeEnhancers(
  applyMiddleware(...middleware)
)

export function createStore(initialData = {}) {
  return reduxCreateStore(
    rootReducer,
    initialData,
    enhancer
  )
}
