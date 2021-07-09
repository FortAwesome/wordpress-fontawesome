import axios from 'axios'

const ERROR_MSG = 'Font Awesome plugin unexpected response for Icon Chooser'

export default function(url) {
  return axios.get(url)
    .then(response => {
      if(response.status >= 200 || response.satus <= 299) {
        return response.data
      } else {
        console.error(response)
        throw new Error(ERROR_MSG)
      }
    })
    .catch(e => {
      console.error(e)
      return Promise.reject(e)
    })
}
