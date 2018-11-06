import React, { Component } from 'react'
import './App.css'
import axios from 'axios'

class App extends Component {

  constructor(props) {
    super(props)

    const wpApiSettings = window['wpFontAwesomeOfficial']

    if(! wpApiSettings) {
      // TODO: probably log this to Sentry instead
      throw Error("missing WP REST API settings object")
    }

    this.state = {
      config: null,
      wpApiSettings
    }
  }

  componentDidMount() {

    axios.get(
      `${this.state.wpApiSettings.api_url}/config`,
      {
        headers: {
          'X-WP-Nonce': this.state.wpApiSettings.api_nonce
        }
      }
    )
      .then(function (response) {
        console.log(response);
      })
      .catch(function (error) {
        console.log(error);
      })
  }

  render() {
    return (
      <div className="App">
          <p>
            Nonce: { this.state.wpApiSettings.api_nonce }
          </p>
      </div>
    )
  }
}

export default App
