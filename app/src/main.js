import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import VueTheMask from 'vue-the-mask';
import App from './App.vue';
import router from './router';
import store from './store';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

Vue.config.productionTip = false;

Vue.use(BootstrapVue);
Vue.use(VueTheMask);

new Vue({
  router,
  store,
  render: h => h(App),
}).$mount('#app');
