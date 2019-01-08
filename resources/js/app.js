import './bootstrap';
import Vue from 'vue';
import Vuex from 'vuex';
import StoreData from './store';
import VueProgressBar from 'vue-progressbar'
import { catchValidate, checkFieldIsEmpty } from '@/js/helpers/validateError';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUser } from '@fortawesome/free-solid-svg-icons';
import { faCommentAlt } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import Routes from '@/js/routes.js';
import App from '@/js/views/App';
import VueMoment from 'vue-moment';
import moment from 'moment-timezone';
import jwtDecode from 'jwt-decode';


library.add([faUser, faCommentAlt]);
Vue.use(VueMoment, {
    moment
});
moment.tz.setDefault('Asia/Bangkok');
moment.locale('th');
Vue.component('font-awesome-icon', FontAwesomeIcon);
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(Vuex);
Vue.use(VueProgressBar, {
    color: 'rgb(115, 40, 253)',
    failedColor: 'red',
    height: '2px'
});
Vue.mixin({
    methods: {
        catchValidate,
        checkFieldIsEmpty
    }
});


const store = new Vuex.Store(StoreData);

function getAuthToken() {
    if (store.getters.getToken) {
        if (jwtDecode(store.getters.getToken).exp - 240 <= (Date.now() / 1000).toFixed(0)) {
            axios.post('/api/auth/refresh', {}, { withCredentials: true })
                .then(response => {
                    store.commit('updateRefreshToken', response.data.access_token);
                    return response.data.access_token
                })
        }
    }
    return store.getters.getToken;
}

Routes.beforeEach((to, from, next) => {
    const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
    const currentUser = store.state.currentUser;

    if (requiresAuth && !currentUser) {
        Routes.push('/login');
    } else if (to.path == '/login' && currentUser) {
        Routes.push('/');
    } else {
        next();
    }
})

axios.interceptors.request.use(async function (config) {
    if(config.method == "post" || config.method == "put" || config.method == "delete") {
        if (config.url.includes('posts') || config.url.includes('new-post') || config.url.includes('edit') || config.url.includes('comments')) {
            config.headers['Authorization'] = 'Bearer ' + await getAuthToken();
        }
    } else {
        config.headers['Authorization'] = 'Bearer ' + store.getters.getToken;
    }
    return config
}, function (error) {
    return Promise.reject(error)
})

axios.interceptors.response.use(null, (error) => {
    if (error.response.status === 401) {
        store.commit('logout');
        Routes.push('/login');
    }

    return Promise.reject(error);
});

if (store.getters.currentUser) {
    setAuthorization(store.getters.currentUser.token);
}

function setAuthorization(token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}




const app = new Vue({
    el: '#app',
    router: Routes,
    store,
    components: { App },
    render: h => h(App)
});

export default app;



