import React from 'react'
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faExclamationTriangle, faClock, faSpinner, faCheck, faSkull } from '@fortawesome/free-solid-svg-icons'
import PropTypes from 'prop-types'
import styles from './V3DeprecationWarning.module.css'
import sharedStyles from './App.module.css'
import axios from 'axios'
import classnames from 'classnames'

class V3DeprecationWarning extends React.Component {

  constructor(props){
    super(props)

    this.state = {
      data: null,
      error: null,
      isLoading: true,
      isSubmitting: false,
      hasSubmitted: false,
      submitSuccess: false,
      submitMessage: null,
    }

    this.getData = this.getData.bind(this)
    this.putData = this.putData.bind(this)
    this.handlePutResponse = this.handlePutResponse.bind(this)
    this.handlePutError = this.handlePutError.bind(this)
    this.handleGetResponse = this.handleGetResponse.bind(this)
    this.handleGetError = this.handleGetError.bind(this)
    this.handleSnooze = this.handleSnooze.bind(this)
  }

  handleSnooze() {
    const newData = {
      snooze: true
    }
    this.putData( newData )
  }

  handleGetResponse(response) {
    const { status, data } = response
    if(200 === status) {
      this.setState({ data, isLoading: false })
    } else {
      this.setState({ error: new Error("failed to get data"), isLoading: false })
    }
  }

  handlePutResponse(response) {
    const { status, data } = response
    if (200 === status) {
      this.setState({
        data,
        isSubmitting: false,
        hasSubmitted: true,
        error: null,
        submitSuccess: true,
        submitMessage: "Changes saved"
      })
    } else {
      this.setState({
        isSubmitting: false,
        hasSubmitted: true,
        error: null,
        submitSuccess: false,
        submitMessage: "Failed to save changes"
      })
    }
  }

  handlePutError(error) {
    const { response: { data: { code, message }}} = error
    let submitMessage = ""

    switch(code) {
      case 'cant_update':
        submitMessage = message
        break
      case 'rest_no_route':
      case 'rest_cookie_invalid_nonce':
        submitMessage = "Sorry, we couldn't reach the server"
        break
      default:
        submitMessage = "Update failed"
    }
    this.setState({ isSubmitting: false, hasSubmitted: true, error: null, submitSuccess: false, submitMessage })
  }

  handleGetError(error) {
    this.setState({ error })
  }

  getData() {
    axios.get(
      `${this.props.wpApiSettings.api_url}/v3deprecation`,
      {
        headers: {
          'X-WP-Nonce': this.props.wpApiSettings.api_nonce
        }
      }
    )
      .then( this.handleGetResponse )
      .catch( this.handleGetError )
  }

  putData(newData){
    this.setState({ isSubmitting: true, hasSubmitted: false })

    axios.put(
      `${this.props.wpApiSettings.api_url}/v3deprecation`,
      newData,
      {
        headers: {
          'X-WP-Nonce': this.props.wpApiSettings.api_nonce
        }
      }
    )
      .then( this.handlePutResponse )
      .catch( this.handlePutError )
  }

  componentDidMount() {
    this.setState({ isLoading: true })
    this.getData()
  }

  render() {
    if(this.state.error) throw this.state.error
    if( !this.state.isLoading && !this.state.data ) throw new Error('missing data')

    if(this.state.isLoading) {
      return null
    } else if( this.state.data ) {
      const { v3DeprecationWarning: { atts, v5name, v5prefix, snooze } } = this.state.data

      if( snooze ) return null

      return <div className={styles['v3-deprecation-warning']}>
        <p className={ sharedStyles['explanation'] }>
          <FontAwesomeIcon icon={ faExclamationTriangle } size="2x"/>
        </p>

          <p className={ sharedStyles['explanation'] }>
            Looks like you're using an <code>[icon]</code> shortcode with an old Font Awesome 3 icon name:
            <code>{ atts.name }</code>
          </p>
          <p className={ sharedStyles['explanation'] }>
            We discontinued support for <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/v3.2.1/icons/">Font Awesome 3</a> quite some time ago,
            though we only recently inherited this WordPress plugin,
            which previously only supported up to Font Awesome 3.
          </p>
          <p className={ sharedStyles['explanation'] }>
            Won't you jump into Font Awesome 5 with us? It's way better, and we're gonna make
            it really easy to upgrade. We've added some temporary magic to this plugin to translate your version 3 icon
            names into their version 5 equivalents.
          </p>
          <p className={ sharedStyles['explanation'] }>
            <i className="fas fa-magic fa-2x"></i> <em>Bippity Boppity Boo!</em>
          </p>
          <p className={ sharedStyles['explanation'] }>
            We just turned your<br/>
            <code>[icon name="{ atts.name }"]</code><br/>
            <i className={ `${ v5prefix } fa-${ v5name } fa-2x` }></i> into<br/>
            <code>[icon name="{ v5name }" prefix="{ v5prefix }"]</code>.
          </p>
          <p className={ sharedStyles['explanation'] }>
            Actually, we just converted it on the fly so it would look right in your web pages,
            without changing your saved web site content. So
            to make that change permanent (and get rid of this warning), you'll need to go change any version 3 icon
            names in <code>[icon]</code> shortcodes in your pages, posts, widgets, templates, or wherever they're coming from.
          </p>
          <p className={ sharedStyles['explanation'] }>
            What's that <code>prefix</code>, you ask?
          </p>
          <p className={ sharedStyles['explanation'] }>
            Well...in Font Awesome 5, most icons come in three different styles. You use a style <em>prefix</em> to indicate
            which style you want. The default style prefix is <code>fas</code> for the Solid style.
            So when you're upgrading your shortcodes from v3 to v5 names, if you just want the Solid style icon,
            you can leave off that <code>prefix</code>. Most v3 icons map to Solid style icons in v5. But some of
            the version 3 icon names map to the <code>fab</code> style for Brands, or the <code>far</code> style for Regular.
          </p>
          <p className={ sharedStyles['explanation'] }>
            Icons for companies like <i className="fab fa-apple fa-2x"></i> Apple, or products like <i className="fab fa-chrome fa-2x"></i>
            Chrome will be in the Brands style with the <code>fab</code> prefix.
          </p>
          <p className={ sharedStyles['explanation'] }>
            When you subscribe to <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/pro">Font Awesome Pro</a>,
            you get a kajillion icons in All the Styles, including <code>fal</code>,
            the Light style.
          </p>
          <p className={ sharedStyles['explanation'] }>
            Head over to our <a rel="noopener noreferrer" target="_blank" href="https://fontawesome.com/icons?d=gallery">Icon Gallery</a> to
            check out the vast array.
          </p>
          <p className={ sharedStyles['explanation'] }>
            Guess what! In Font Awesome 3.2.1, you had
            361 icons to choose from. Now, with Font Awesome 5 Free (as of v5.5.0) you've got <b>1,409</b>,
            and with Pro you get...wait for it...<b>4,566</b>. (Rounds up to a kajillion.)
          </p>
          <p className={ sharedStyles['explanation'] }>
            So have a blast upgrading. We're gonna remove this v3-to-v5 magic soon, though,
            so don't wait forever.
          </p>
        <p className={ sharedStyles['explanation'] }>
          Clear this warning by updating those icons, or you could hit snooze to get this warning of your way for a while.
        </p>
        <div>
          <button disabled={ this.state.isSubmitting } onClick={ this.handleSnooze } className={ classnames( styles['snooze-button'], 'button', 'button-primary' ) }>
            {
              this.state.isSubmitting
                ?  <FontAwesomeIcon icon={ faSpinner } spin className={ styles['submitting'] } />
                : this.state.hasSubmitted
                ? this.state.submitSuccess
                  ? <FontAwesomeIcon icon={ faCheck } className={ styles['success'] }/>
                  : <FontAwesomeIcon icon={ faSkull } className={ styles['fail'] }/>
                : <FontAwesomeIcon icon={ faClock } className={ styles['snooze'] }/>
            }
            <span className={ styles['label'] }>Snooze</span>
          </button>
        </div>

      </div>
    }
  }
}

export default V3DeprecationWarning

V3DeprecationWarning.propTypes = {
  wpApiSettings: PropTypes.object.isRequired,
}


