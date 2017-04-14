import VueRouter from 'vue-router'
import Form from './utilities/Form'

window._ = require('lodash');

// window.$ = window.jQuery = require('jquery');

window.Vue = require('vue');

Vue.use(VueRouter);

window.Form = Form;

window.axios = require('axios');

window.axios.defaults.headers.common = {
    'X-CSRF-TOKEN': window.Laravel.csrfToken,
    'X-Requested-With': 'XMLHttpRequest'
};