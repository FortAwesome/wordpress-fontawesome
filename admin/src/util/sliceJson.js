function findJson( content, start = 0 ) {
  let parsed = null
  let nextStart = null

  if ( 'string' !== typeof content ) return null
  if ( start >= content.length ) return null

  try {
    parsed = JSON.parse( content.slice(start) )
    return {
      start,
      parsed
    }
  } catch( _e ) {
    // search for the next character that would begin a JSON response
    const nextLeftBracket = content.indexOf('[', start + 1)
    const nextLeftBrace = content.indexOf('{', start + 1)

    if( -1 === nextLeftBracket && -1 === nextLeftBrace ) {
      // we've search to the end and found no chars that would start JSON content
      return null
    } else {
      if ( -1 !== nextLeftBracket && -1 !== nextLeftBrace ) {
        // if we found both, take the lower one
        nextStart = nextLeftBracket < nextLeftBrace
          ? nextLeftBracket
          : nextLeftBrace
      } else if ( -1 !== nextLeftBrace ) {
        nextStart = nextLeftBrace
      } else {
        nextStart = nextLeftBracket
      }
    }
  }

  if ( null === nextStart ) {
    return null
  } else {
    return findJson( content, nextStart )
  }
}

/**
 * Searches through the given content trying to skip over any non-JSON string
 * data to find JSON data.
 * 
 * Returns null if none found.
 * 
 * Otherwise, returns an object indicating the starting index for the found JSON,
 * the json content as an unparsed string, the non-json content trimmed from the
 * beginning, and the parsed JSON.
 */
export default function( content ) {
  if(! content || '' === content ) return null

  const result = findJson( content )

  if ( null === result ) {
    return null
  } else {
    const { start, parsed } = result

    return {
      start,
      json: content.slice(start),
      trimmed: content.slice(0, start),
      parsed
    }
  }
}
