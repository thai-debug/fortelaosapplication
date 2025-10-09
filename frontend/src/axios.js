import axios from "axios";

axios.defaults.baseURL = 'http://localhost:8000'
axios.defaults.withCredentials = true
axios.defaults.withXSRFToken = true

export async function initCSRF() {
    await axios.get('/sanctum/csrf-cookie')
}

export default axios