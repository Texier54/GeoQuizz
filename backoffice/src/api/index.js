import axios from 'axios'
import conf from '../config'

const api = axios.create({
    baseURL: conf.remoteURL,
    headers: {
        'Authorization' : 'Token token='+conf.apiKey
    }
})
export default api