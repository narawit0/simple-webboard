import jwtDecode from 'jwt-decode';

export function getAuthToken(store) {
    console.log(store.getters);
    var check = jwtDecode(store.getters.getToken).exp - 240 <= (Date.now() / 1000).toFixed(0);
    console.log(check);
    if (check) {
        axios.post('/api/auth/refresh', {}, { withCredentials: true })
            .then(response => {
                store.commit(updateRefreshToken, response.data.access_token);
                return response.data.access_token
            })
    }
    return store.getters.getToken;
}

function resetAuthTokenRequest() {
    authTokenRequest = null
}

export function initialize(store, router) {
    router.beforeEach((to, from, next) => {
        const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
        const currentUser = store.state.currentUser;

        if (requiresAuth && !currentUser) {
            router.push('/login');
        } else if (to.path == '/login' && currentUser) {
            router.push('/');
        } else {
            next();
        }
    })

    axios.interceptors.request.use(async function (config) {
        if (!config.url.includes('login')) {
            config.headers['Authorization'] = 'Bearer ' + await getAuthToken();
        } else {
            config.headers['Authorization'] = 'Bearer ' + store.getters.getToken;
        }
        return config
    }, function (error) {
        return Promise.reject(error)
    })

    // axios.interceptors.response.use(null, (error) => {
    //     console.log('yes');
    //     console.log(error);
    //     if (error.response.status === 401) {
    //         store.commit('logout');
    //         router.push('/login');
    //     }

    //     return Promise.reject(error);
    // });

    if (store.getters.currentUser) {
        setAuthorization(store.getters.currentUser.token);
    }
}

export function setAuthorization(token) {
    axios.defaults.headers.common["Authorization"] = `Bearer ${token}`
}