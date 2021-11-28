/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('./cropme');

window.Vue = require('vue');

import VueRouter from 'vue-router'
import router from './route'
import VueProgressBar from 'vue-progressbar'
import moment from 'moment';
import Lightbox from 'vue-easy-lightbox'
Vue.use(Lightbox)

window.moment = moment;
import _ from 'lodash';
Vue.prototype.trans = (key) => {
    return _.get(window.trans, key, key);
};


import 'vue2-datepicker/index.css';

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '100px'
})

Vue.use(VueRouter)

// ES6 Modules or TypeScript
import swal from 'sweetalert2'
window.swal = swal;

const toast = swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  onOpen: (toast) => {
    toast.addEventListener('mouseenter', swal.stopTimer)
    toast.addEventListener('mouseleave', swal.resumeTimer)
  }
});
window.toast = toast;

  // Admin Dashboard
  Vue.component('admin-sidebar',require('./components/Dashboard/Admin/Sidebar.vue').default );
  Vue.component('request-noti',require('./components/Dashboard/Admin/RequestNoti.vue').default );

  // Member Dashboard
  Vue.component('member-sidebar',require('./components/Dashboard/Member/Sidebar.vue').default );

   // All Access Dashboard
  Vue.component('all-sidebar',require('./components/Dashboard/All/Sidebar.vue').default );

  const app = new Vue({
    router
  }).$mount('#app')
