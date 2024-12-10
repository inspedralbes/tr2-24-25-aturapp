import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/home',
      name: 'home',
      component: () => import('../views/LandingPage.vue'),
    },
    {
      path: '/',
      name: 'mobile',
      component: () => import('../views/Mobile.vue'),
    },
    {
      path: '/access',
      name: 'access',
      component: () => import('../views/access.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../components/login.vue'),
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../components/register.vue'),
    },
  ],
});

router.beforeEach((to, from, next) => {
  const SessionIniciada = localStorage.getItem('loggedIn') === 'true';
  const PaginasPublicas = ['/access', '/login', '/register', '/home'];
  const EsPaginaPublica = PaginasPublicas.includes(to.path);

  if (!SessionIniciada && !EsPaginaPublica) {
    next('/home');
  } else {
    next();
  }
});

export default router;