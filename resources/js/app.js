import Vue from 'vue';
import store from '~/store';
import router from '~/router';
import i18n from '~/plugins/i18n';
import App from '~/components/App';
import DataTable from 'laravel-vue-datatable';
Vue.use(DataTable);
import vuescroll from 'vuescroll';
 import Multiselect from 'vue-multiselect'

  // register globally
  Vue.component('multiselect', Multiselect)
Vue.use(vuescroll)
// Import component
import 'vue-loading-overlay/dist/vue-loading.css';


import '~/plugins';
import '~/components';


import base_url from '~/plugins/baseUrl';
import showMessage from '~/plugins/alert';
window.base_url = base_url;
window.showMessage = showMessage;

Vue.component('custom-input', {
  props: ['value'],
  template: `
    <input
     	v-model="value"
    >
  `
})

Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
