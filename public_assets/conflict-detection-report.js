function reportDetectedConflicts(params){
  var nodesTested = params.nodesTested || {}
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

  var payload = Object.keys(nodesTested.conflict).reduce(function(acc, md5){
    acc[md5] = nodesTested.conflict[md5]
    return acc
  }, {})

  var errorMsg = 'Font Awesome Conflict Detection: found ' +
    Object.keys(payload).length + ' conflicts' +
    ' but failed when trying to submit them to your WordPress server. Sorry!'+
    ' You might just try again by reloading this page.';

  FETCH(
    apiBaseUrl + '/report-conflicts',
    {
      headers: {
        'X-WP-Nonce': apiNonce,
        'Content-Type': 'application/json'
      },
      method: 'POST',
      body: JSON.stringify(payload)
    }
  )
  .then(function(response){
    if( response.ok ) {
      alert('Font Awesome Conflict Detection: ran successfully and submitted ' +
        Object.keys(payload).length +
        ' conflicts to your WordPress server.' +
        ' You can use the Font Awesome plugin settings page to manage them.');
    } else {
      alert(errorMsg);
    } 
  })
  .catch(function(error){
    alert(errorMsg);
  })
}

window.FontAwesomeDetection = {
  report: reportDetectedConflicts
}