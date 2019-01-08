import Vue from 'vue';
import VueRouter from 'vue-router';

import PageNotFound from '@/js/views/PageNotFound';
import Register from '@/js/views/Register';
import Login from '@/js/views/Login';
import Home from '@/js/views/Home';
import NewPost from '@/js/components/NewPost';
import PostList from '@/js/components/PostList';
import Post from '@/js/components/Post';
import PostChannelList from '@/js/components/PostChannelList';
import EditPost from '@/js/components/EditPost';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '*',
            component: PageNotFound
        },
        {
            path: '/',
            component: Home,
            children: [
                {
                    path: '/',
                    component: PostList
                },
                {
                    path: '/new-post',
                    component: NewPost,
                    meta: {
                        requiresAuth: true
                    }
                },
                {
                    path: '/posts/:id',
                    component: Post,
                    props: true
                },
                {
                    path: '/posts/:id/edit',
                    component: EditPost,
                    props: true
                },
                {
                    path: '/posts/channels/:channel',
                    component: PostChannelList,
                    props: true
                },
            ]
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/login',
            name: 'login',
            component: Login
        }
    ],
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
      }
});

export default router;
