import React from 'react'
import PropTypes from 'prop-types'
import styles from './PluginVersionWarningsView.module.css'
import sharedStyles from './App.module.css'
import classnames from 'classnames'

const PluginVersionWarningsView = props => (
    <div className={ styles['plugin-version-warnings'] } >
      <h2>Plugin Version Warnings</h2>
      <p className={ sharedStyles['explanation'] }>
        This plugin is designed to be loaded in a variety of ways by third-party plugins and themes, all in the hope
        that it makes your life easier by managing the complexity of their various requirements. But sometimes, they
        have a conflict over not just the version of Font Awesome to load, but on the version of this plugin that they
        require in order to get the job done. Behind the scenes, only one copy of the plugin is actually loaded. Any
        subsequent plugins are forced to use that version that's already loaded. Those subsequently loaded plugins
        might have a problem using the loaded version and this is where they'll warn you about that so you can
        see the problem clearly and (hopefully) quickly work out a solution.
      </p>
      <p className={ sharedStyles['explanation'] }>
        Unfortunately, we've got one of those situations here. The likely solution is to upgrade one of these to
        its latest version. Or, if you've installed a plugin that includes the Font Awesome plugin and you've also
        installed the Font Awesome plugin directly yourself, you might be able to resolve this conflict by deactivating
        the version of the Font Awesome plugin you installed yourself.
      </p>
      <p className={ sharedStyles['explanation'] }>
        If you have reason to keep your own installation of the plugin in addition to another plugin and think you could
        resolve this problem by downgrading your own installation of the plugin, you find older releases of the plugin
        on <a href="https://fontawesome.com">our website</a>.
      </p>
      <p className={ sharedStyles['explanation'] }>
        In most cases, if you've installed a plugin that embeds this plugin, you do not need to also have your own
        copy of this plugin installed, and it may be simpler to just deactivate and uninstall it, unless it's the
        only copy of the plugin.
      </p>
      <p className={ sharedStyles['explanation'] }>
        <b>Loaded Plugin Version: </b> { props.pluginVersion }
      </p>
        <table className={classnames('widefat', 'striped')}>
            <thead>
              <tr className={ sharedStyles['table-header'] }>
                <th>Name</th>
                <th>Version Requirement</th>
              </tr>
            </thead>
            <tbody>
            {
              props.warnings.map( (warning, index) => (
                <tr key={ index }>
                  <td className={styles['name']}>{ warning.name }</td>
                  <td className={styles['name']}>{ warning.constraint }</td>
                </tr>
              ))
            }
            </tbody>
        </table>
    </div>
)

export default  PluginVersionWarningsView

PluginVersionWarningsView.propTypes = {
  warnings: PropTypes.array.isRequired,
  pluginVersion: PropTypes.string.isRequired
}
