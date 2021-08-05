import axios from 'axios'

const ERROR_MSG = 'Font Awesome plugin unexpected response for Icon Chooser'

const getUrlText = (url) => {
  return axios.get(url)
    .then(response => {
      if(response.status >= 200 || response.satus <= 299) {
        return response.data
      } else {
        console.error(response)
        return Promise.reject(ERROR_MSG)
      }
    })
    .catch(e => {
      console.error(e)
      return Promise.reject(e)
    })
}

export default getUrlText
