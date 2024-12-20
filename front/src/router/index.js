import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      // path: '/',
      // redirect: '/home',
    },
    {
      path: '/home',
      name: 'home',
      component: () => import('../views/LandingPage.vue'),
    },
    {
      path: '/',
      name: 'mobile',
      component: () => import('../views/Mobile.vue')
    }
  ],
});

export default router;
