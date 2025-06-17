import { createApp } from 'vue'
import router from './router'
import App from './components/App.vue'
import axios from 'axios'
import '../css/app.css';

// Configure axios
axios.defaults.baseURL = '/'
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'
axios.defaults.headers.common['Accept'] = 'application/json'



const app = createApp(App)

app.config.globalProperties.$http = axios
app.use(router)
app.mount('#app')