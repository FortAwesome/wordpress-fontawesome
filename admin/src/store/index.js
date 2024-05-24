import { createReduxStore, register } from '@wordpress/data'
import rootReducer from './reducers'

export function createStoreDescriptor(initialData = {}) {
  const storeDescriptor = createReduxStore('font-awesome-official', {
    reducer: rootReducer,
    initialState: initialData
  })

  register(storeDescriptor)
  return storeDescriptor
}
