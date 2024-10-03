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
            // children: [
            //     {
            //         name: 'ProductDetail',
            //         path: 'product',
            //         component: () => import('@/pages/ProductDetailPage.vue')
            //     }
            // ]
        },
        {
            name: 'ProductDetail',
            path: '/catalog/product',
            component: () => import('@/pages/ProductDetailPage.vue')
        }
    ]
});

export default router;