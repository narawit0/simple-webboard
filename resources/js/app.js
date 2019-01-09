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
import { initialize } from '@/js/helpers/general';


library.add([faUser, faCommentAlt]);
Vue.use(VueMoment, {
    moment
});
moment.tz.setDefault('Asia/Bangkok');
moment.locale('th');
Vue.component('font-awesome-icon', FontAwesomeIcon);
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


export const store = new Vuex.Store(StoreData);

initialize(store, Routes);


const app = new Vue({
    el: '#app',
    router: Routes,
    store,
    components: { App },
    render: h => h(App)
});

export default app;



