import { createRouter, createWebHistory } from 'vue-router';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'landingPage',
      component: () => import('../views/LandingPage.vue'),
    },
    {
      path: '/home',
      name: 'home',
      component: () => import('../components/HomeComp.vue'),
    },
    {
      path: '/access',
      name: 'access',
      component: () => import('../views/access.vue'),
    },
    {
      path: '/analisis',
      name: 'analisis',
      component: () => import('../views/analisis.vue'),
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../components/login.vue'),
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../components/register.vue')
    },
    {
      path: '/chat',
      name: 'chat',
      component: () => import('../components/ChatComp.vue')
    },
    {
      path: '/mapa',
      name: 'mapa',
      component: () => import('../components/MapComp.vue')
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: () => import('../components/UserComp.vue')
    },
    {
      path: '/perfil/alertes',
      name: 'mevesAlertes',
      component: () => import('../components/MevesAlertesComp.vue')
    },
    {
      path: '/perfil/dades',
      name: 'dades',
      component: () => import('../components/DadesUserComp.vue')
    },
    {
      path: '/soport',
      name: 'soport',
      component: () => import('../components/SoportComp.vue')
    },
    {
      path: '/chat',
      name: 'chat',
      component: () => import('../components/ChatComp.vue')
    },
    {
      path: '/mapa',
      name: 'mapa',
      component: () => import('../components/MapComp.vue')
    },
    {
      path: '/perfil',
      name: 'perfil',
      component: () => import('../components/UserComp.vue')
    },
    {
      path: '/perfil/alertes',
      name: 'mevesAlertes',
      component: () => import('../components/MevesAlertesComp.vue')
    },
    {
      path: '/perfil/alertes/editar',
      name: 'editarAlerta',
      component: () => import('../components/EditarAlertaComp.vue')
    },
    {
      path: '/perfil/dades',
      name: 'dades',
      component: () => import('../components/DadesUserComp.vue')
    },
    {
      path: '/soport',
      name: 'soport',
      component: () => import('../components/SoportComp.vue')
    },
    {
      path: '/enquesta',
      name: 'enquesta',
      component: () => import('../components/enquesta.vue')
    },
  ],
});

/*
router.beforeEach((to, from, next) => {
  const sessionData = JSON.parse(localStorage.getItem('loggedIn'));
  const SessionIniciada = sessionData?.Iniciado === true;
  const PaginasPublicas = ['/access', '/login', '/register', '/'];
  const EsPaginaPublica = PaginasPublicas.includes(to.path);

  if (!SessionIniciada && !EsPaginaPublica) {
    next('/');
  } else if (SessionIniciada && to.path === '/') {
    next('/home');
  } else {
    next();
  }
});
*/

export default router;