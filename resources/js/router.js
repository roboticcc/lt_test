import './bootstrap';
import { createRouter, createWebHistory } from "vue-router"

const routes = [
    {
        path: '/tasks',
        component: () => import('./components/task/Index.vue'),
        name: 'tasks.index'
    },
    {
        path: '/',
        component: () => import('./components/user/Login.vue'),
        name: 'user.login'
    },
    {
        path: '/register',
        component: () => import('./components/user/Registration.vue'),
        name: 'user.register'
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
    const accessToken = localStorage.access_token

    if (to.name !== 'user.login' && to.name !== 'user.register' && !accessToken) {
            return next({
                name: 'user.login'
            });
    }

    if (to.name !== 'tasks.index' && accessToken){
            return next({
                name: 'tasks.index'
            });
    }

    next();
})

export default router
