import React from 'react'
import Alert from './Alert'

const ReleaseProviderWarning = () => (
  <Alert title='Whoa, this is unusual.' type='warning'>
    <p>
      We were not able to able to retrieve information about available releases from Font Awesome's web server.
      This is something that happens on the back end, when your WordPress server contacts the Font Awesome server.
      Without that, this plugin doesn't have the configuration data it needs to load Font Awesome for you.
    </p>
    <p>
      Normally, this would only happen if you're trying to run WordPress offline or if there's some unexpected
      error in your WordPress server. If you run your own WordPress server, you might check server logs to see
      if they indicate what's going on. If you rely on a hosting provider or other system administrator, you might
      let them know about this and see if they can help you figure out what's going on with your WordPress server.
    </p>
    <p>
      You might also find clues in WordPress <a rel="noopener noreferrer" target="_blank" href="https://wordpress.org/support/wordpress-version/version-5-2/#site-health-check">SiteHealth</a> if
      you're using WordPress 5.1 or later. Go to Tools > Site Health.
    </p>
    <p>
      If following those paths to troubleshoot your WordPress server doesn't yield a solution, you can try to post a
      request for help in the <a href="https://wordpress.org/support/plugin/font-awesome/" rel="noopener noreferrer" target="_blank">plugin's support forum</a>.
    </p>
  </Alert>
)

export default ReleaseProviderWarning

