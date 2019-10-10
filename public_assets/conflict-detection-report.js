function reportDetectedConflicts(params){
  var nodesTested = params.nodesTested || {}
  var md5ForFontFaceShimInlineStyle = 'f3350ebe5e9c1693c9864031b56b381f'
  var apiNonce = window.wpFontAwesomeOfficialConflictReporting['api_nonce'] || null
  var apiBaseUrl = window.wpFontAwesomeOfficialConflictReporting['api_url'] || null
  var FETCH = typeof window.fetch == 'function' ? window.fetch : null

  if(! FETCH) {
    alert("Font Awesome Conflict Detection: not supported for this browser. Please try again with a current version browser.")
    return
  }

  if( !apiNonce || !apiBaseUrl ) {
    alert("Font Awesome Conflict Detection failed because it's not properly configured.")
    return
  }

  var promises = []

  Object.keys(nodesTested.conflict).map(function(key){
    promises.push(
      FETCH(
        apiBaseUrl + '/report-conflicts',
        {
          headers: {
            'X-WP-Nonce': apiNonce,
            'Content-Type': 'application/json'
          },
          method: 'POST',
          body: JSON.stringify(nodesTested.conflict[key])
        }
      )
    )
  })

  Promise.all(promises)
  .then(function(results){
    alert('done')
  })
  .catch(function(error){
    alert('error')
  })
}

window.FontAwesomeDetection = {
  report: reportDetectedConflicts
}