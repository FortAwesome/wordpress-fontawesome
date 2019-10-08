import React, { Component } from 'react'
import axios from 'axios'
import LoadingView from './LoadingView'
import FontAwesomeAdminView from './FontAwesomeAdminView'
import { size } from 'lodash'

class App extends Component {

  constructor(props) {
    super(props)

    const wpApiSettings = window['wpFontAwesomeOfficial']

    if(! wpApiSettings) {
      throw Error("Well, this is embarrassing. The plugin doesn't seem to be installed correctly.")
    }

    this.state = {
      data: null,
      error: null,
      isLoading: true,
      isSubmitting: false,
      hasSubmitted: false,
      submitSuccess: false,
      submitMessage: null,
      wpApiSettings
    }

    this.getData = this.getData.bind(this)
    this.putData = this.putData.bind(this)
    this.handlePutResponse = this.handlePutResponse.bind(this)
    this.handlePutError = this.handlePutError.bind(this)
    this.handleGetResponse = this.handleGetResponse.bind(this)
    this.handleGetError = this.handleGetError.bind(this)
  }

  handleGetResponse(response) {
    const { status, data } = response
    if(200 === status) {
      this.setState({
        data: {...data, conflicts: size(data.conflicts) === 0 ? {} : data.conflicts},
        isLoading: false
      })
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
      `${this.state.wpApiSettings.api_url}/config`,
      {
        headers: {
          'X-WP-Nonce': this.state.wpApiSettings.api_nonce
        }
      }
    )
    .then( this.handleGetResponse )
    .catch( this.handleGetError )
  }

  putData(newData){
    this.setState({ isSubmitting: true, hasSubmitted: false })

    axios.put(
      `${this.state.wpApiSettings.api_url}/config`,
      newData,
      {
        headers: {
          'X-WP-Nonce': this.state.wpApiSettings.api_nonce
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

    return (
      <div className="wrap">
        {
          this.state.isLoading
          ? <LoadingView/>
          : <FontAwesomeAdminView
              data={ this.state.data }
              putData={ this.putData }
              isSubmitting={ this.state.isSubmitting }
              hasSubmitted={ this.state.hasSubmitted }
              submitSuccess={ this.state.submitSuccess }
              submitMessage={ this.state.submitMessage }
              wpApiSettings={ this.state.wpApiSettings }
              error={ this.state.error }
            />
        }
      </div>
    )
  }
}

export default App
