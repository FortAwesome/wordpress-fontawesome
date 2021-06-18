const { Component } = window.wp.element

import debounce from 'lodash/debounce'
import axios from 'axios'
import get from 'lodash/get'
import size from 'lodash/size'
import difference from 'lodash/difference'

const className = 'font-awesome-icon-chooser'

const STYLE_RESULT_TO_PREFIX = {
  solid: 'fas',
  duotone: 'fad',
  regular: 'far',
  light: 'fal'
}

export default class FontAwesomeIconChooser extends Component {
  constructor() {
    super(...arguments)

    this.state = {
      queryResults: [],
      iconDefinitions: [],
      query: '',
      isSearching: false
    }

    this.updateQueryResults = debounce( query => {
      this.setState({isSearching: true})
      this.search(query)
    }, 500 )

    this.onChangeQuery = this.onChangeQuery.bind(this)
    this.search = this.search.bind(this)
  }

  onChangeQuery(e) {
    const query = e.target.value
    this.setState({ query })
    this.updateQueryResults(query)
  }

  search(query) {
    const { version, usingPro } = window['__FontAwesomeOfficialPlugin_EditorSupportConfig__']

    axios.post(
      `https://api.fontawesome.com`,
      {
        query: `
        query {
          search(version:"${version}", query: "${query}", first: 10) {
            id
            label
            membership {
              free
              ${ usingPro ? 'pro' : '' }
            }
          }
        }
        `
      },
    ).then(response => {
      const { data } = response

      // TODO: handle the case where there are errors in the data.
      // if data.errors...

      const iconDefinitions = data.data.search.reduce((acc, result) => {
        const { id, membership } = result

        const styles = membership.free

        if(membership.pro) {
          const alsoProStyles = difference(styles, membership.pro)
          styles.concat(alsoProStyles)
        }

        styles.map(style => {
          // TODO: do we want to change this to expose some API so we don't have
          // to reach into the internals?
          const prefix = STYLE_RESULT_TO_PREFIX[style]

          acc.push({
            iconName: id,
            prefix 
          })
        })

        return acc
      }, [])

      this.setState({ isSearching: false, queryResults: data.search, iconDefinitions })
    }).catch(error => {
      console.log('DEBUG: query error:', error)
      this.setState({ isSearching: false })
    })
  }


  render(){
    const { handleSelect } = this.props

    return <div className={className}>
      <div>
        <input value={ this.state.query } onChange={ this.onChangeQuery } placeholder="search..."></input>
      </div>
      <div>
        <ul className={'icons'}>
          {
            size(this.state.query) === 0
            ? <p>type to search</p>
            : (
              this.state.isSearching
              ? <p>searching...</p>
              : (size(this.state.iconDefinitions) > 0
                  ?  this.state.iconDefinitions.map(iconDefinition => 
                      <li key={ `${ iconDefinition.prefix }-${ iconDefinition.iconName }`}>
                        <button onClick={() => handleSelect(iconDefinition)}>
                          <i className={ `${iconDefinition.prefix} fa-${iconDefinition.iconName}` }></i>
                        </button>
                      </li>
                    )
                  : <p>(no results)</p>
                )
            )
          }
        </ul>
      </div>
    </div>
  }
}

