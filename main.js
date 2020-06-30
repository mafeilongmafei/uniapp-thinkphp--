import Vue from 'vue'
import App from './App'
import VueClipboard from 'vue-clipboard2'
import store from "./store/index.js"
import "./util/init.js"
import "./request/socket.js"
import "./util/filter.js"


Vue.use(VueClipboard);
Vue.config.productionTip = false
Vue.prototype.$store = store

App.mpType = 'app'



const app = new Vue({
	store,
    ...App,
	
})
app.$mount()
