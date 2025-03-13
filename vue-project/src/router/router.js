import {createRouter, createWebHistory} from "vue-router";

const router = createRouter({
    history: createWebHistory('/'),
    routes: [
        {
            name: 'main',
            path: '/',
            component: () => import('@/pages/MainPage.vue')
        },
        {
            name: 'catalog',
            path: '/catalog/:slug(.*)',
            component: () => import('@/pages/CatalogPage.vue'),
        },
        {
            name: 'not-found',
            path: '/:pathMatch(.*)*',
            component: () => import('@/pages/404Page.vue'),
        },
        {
            name: 'register',
            path: '/register/',
            component: () => import('@/pages/RegisterAuthPage.vue')
        },
        {
            name: 'personal',
            path: '/personal/',
            component: () => import('@/pages/PersonalPage.vue')
        },
        {
            name: 'cart',
            path: '/cart/',
            component: () => import('@/pages/CartPage.vue')
        },
        {
            name: 'checkout',
            path: '/checkout/',
            component: () => import('@/pages/CheckoutPage.vue')
        },
    ]
});

export default router;