const CACHE_KEY_PREFIX = 'wp-font-awesome-cache'

function buildPrefixedKey(key) {
  return `${CACHE_KEY_PREFIX}-${key}`
}

// This removes all items in localStorage whose keys begin
// with this modules CACHE_KEY_PREFIX.
export function clearQueryCache() {
  if(!window?.localStorage) return

  if(localStorage.length == 0) return

  for(let i=localStorage.length - 1; i>=0; i--) {
    const key = localStorage.key(i)
    if(key.startsWith(CACHE_KEY_PREFIX)) {
      localStorage.removeItem(key)
    }
  }
}

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

  const prefixedCacheKey = buildPrefixedKey(key)

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

  const prefixedCacheKey = buildPrefixedKey(key)

  try {
    const valueJson = JSON.stringify(value)
    localStorage.setItem(prefixedCacheKey, valueJson)
  } catch {
    return
  }
}
