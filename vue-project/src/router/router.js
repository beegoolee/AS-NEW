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
            path: '/catalog',
            component: () => import('@/pages/CatalogPage.vue'),
        },
        {
            name: 'ProductDetail',
            path: '/catalog/product/:productCode',
            component: () => import('@/pages/ProductDetailPage.vue')
        },
        {
            name: 'not-found',
            path: '/:pathMatch(.*)*',
            component: () => import('@/pages/404Page.vue'),
        }
    ]
});

export default router;