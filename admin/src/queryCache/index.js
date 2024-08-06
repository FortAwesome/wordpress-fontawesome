const CACHE_KEY_PREFIX = 'wp-font-awesome-cache'

export function remove(prefixedCacheKey) {
  if('function' !== typeof window?.localStorage?.removeItem) return
  localStorage.removeItem(prefixedCacheKey)
}

// Takes a cache that is *not* prefixed.
// Expects to be able to add its prefix, and get an item from localStorage
// which must be JSON-parseable.
//
// On success, returns the result of the cache value after JSON.parse().
// On failure, returns undefined: if there's no matching key, or an error
// in JSON parsing.
export function get(key) {
  if('function' !== typeof window?.localStorage?.getItem) return

  const prefixedCacheKey = `${CACHE_KEY_PREFIX}-${key}`

  const cacheValueJson = localStorage.getItem(prefixedCacheKey)

  try {
    const cacheValue = JSON.parse(cacheValueJson)

    if(cacheValue) {
      return cacheValue
    } else {
      return
    }
  } catch {
    remove(prefixedCacheKey)
    return
  }
}

// Takes a key that has not been prefixed, and a value that must be passable
// as an argument to JSON.stringify().
//
// Prefixes the key, and stores the JSON-stringified value in localStorage.
//
// Always returns undefined.
export function set(key, value) {
  if('function' !== typeof window?.localStorage?.setItem) return

  const prefixedCacheKey = `${CACHE_KEY_PREFIX}-${key}`

  try {
    const valueJson = JSON.stringify(value)
    localStorage.setItem(prefixedCacheKey, valueJson)
  } catch {
    return
  }
}
