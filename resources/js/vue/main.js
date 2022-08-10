import Vue from 'vue'
import router from './router'
import store from './store'
import App from './App'
import can from './helpers/can'
import requestInterceptor from '@vue/plugins/axios/requestInterceptor'
import { onFulfilled, onRejected } from '@vue/plugins/axios/responseInterceptor'

// Configure axios
axios.interceptors.request.use(requestInterceptor)
axios.interceptors.response.use(onFulfilled, onRejected)

// Add permissions helper
Vue.prototype.$can = can

const app = new Vue({
    el: '#app',
    components: { App },
    router,
    store
});
