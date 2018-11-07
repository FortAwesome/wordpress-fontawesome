import React, { Component } from 'react'
import axios from 'axios'
import LoadingView from './LoadingView'
import FontAwesomeAdminView from './FontAwesomeAdminView'

class App extends Component {

  constructor(props) {
    super(props)

    const wpApiSettings = window['wpFontAwesomeOfficial']

    if(! wpApiSettings) {
      // TODO: probably log this to Sentry instead
      throw Error("missing WP REST API settings object")
    }

    this.state = {
      data: null,
      error: null,
      isLoading: true,
      wpApiSettings
    }

    this.getData = this.getData.bind(this)
    this.putData = this.putData.bind(this)
    this.handleDataResponse = this.handleDataResponse.bind(this)
    this.handleDataError = this.handleDataError.bind(this)
  }

  handleDataResponse(response) {
    const { status, data } = response
    if(200 === status) {
      this.setState({ data, isLoading: false })
    } else {
      this.setState({ error: new Error("failed to get data"), isLoading: false })
    }
  }

  handleDataError(error) {
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
    .then( this.handleDataResponse )
    .catch( this.handleDataError )
  }

  putData(newData){
    return axios.put(
      `${this.state.wpApiSettings.api_url}/config`,
      newData,
      {
        headers: {
          'X-WP-Nonce': this.state.wpApiSettings.api_nonce
        }
      }
    )
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
          : <FontAwesomeAdminView data={ this.state.data } putData={ this.putData }/>
        }
      </div>
    )
  }
}

export default App
