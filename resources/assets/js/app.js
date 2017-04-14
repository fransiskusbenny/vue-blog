import router from './routes'

require('./bootstrap');

window.ev = new class {
    constructor() {
        this.vue = new Vue();
    }

    fire(event, data = null) {
        this.vue.$emit(event, data);
    }

    listen(event, callback) {
        this.vue.$on(event, callback);
    }
}

axios.interceptors.response.use((response) => {
    return response;
}, (error) => {
    
    if (error.response.status == 404) {
        router.push({name: 'error.404'});
    }
    
    if (error.response.status == 401) {
        router.push({name: 'error.401'});
    }

    
    return Promise.reject(error);
});

Vue.component('Navbar', require('./views/partials/navbar.vue'));
Vue.component('Banner', require('./components/Banner'));


const app = new Vue({
    el: '#app',

    router,

    mounted() {
        
    }
});

