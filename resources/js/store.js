import { getLocalUser } from "./helpers/auth";

const user = getLocalUser();
var token = user ? user.token : '';

export default {
    state: {
        currentUser: user,
        token: token,
        isLoggedIn: !!user,
        loading: false,
        auth_error: '',
        posts: [],
        channels: [],
        postsChannel: []
    },
    mutations: {
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedIn = true;
            state.loading = false;
            state.currentUser = Object.assign({}, payload.user, { token: payload.access_token });
            state.token = payload.access_token;
            localStorage.setItem("user", JSON.stringify(state.currentUser));
        },
        loginFailed(state, error) {
            state.loading = false;
            state.auth_error = error;
        },
        logout(state) {
            localStorage.removeItem("user");
            state.isLoggedIn = false;
            state.currentUser = null;
            state.token = null;
        },
        updatePosts(state, payload) {
            state.posts = payload;
        },
        updateChannels(state, payload) {
            state.channels = payload;
        },
        updatePostsChannel(state, payload) {
            state.postsChannel = payload;
        },
        updateRefreshToken(state, payload) {
            state.currentUser.token = payload;
            state.token = payload;
        }
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedIn(state) {
            return state.isLoading;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        posts(state) {
            return state.posts;
        },
        channels(state) {
            return state.channels;
        },
        postsChannel(state) {
            return state.postsChannel;
        },
        getToken(state) {
            return state.token;
        }
    },
    actions: {
        login(context) {
            context.commit("login");
        },
        getPosts(context, page) {
            axios.get(`/api/posts?page=${page}`)
                .then(response => {
                    context.commit('updatePosts', response.data.posts);
                });
        },
        getChannels(context) {
            axios.get('/api/channels')
                .then(response => {
                    context.commit('updateChannels', response.data.channels);
                })
        },
        getPostsByChannel(context, channel) {
            axios.get(`/api/posts/channels/${channel}`)
                .then(response => {
                    context.commit('updatePostsChannel', response.data.posts);
                })
        }
    }
}