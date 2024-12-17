import { createRouter, createWebHistory } from 'vue-router';
import { useCounterStore } from '../stores/counter';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: "login"
      // name: 'landingPage',
      // component: () => import('../views/LandingPage.vue'),
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
    {
      path: '/heatmap',
      name: 'heatmap',
      component: () => import('../components/HeatmapComp.vue')
    },
  ],
});

router.beforeEach((to, from, next) => {
  const store = useCounterStore();

  const SessionIniciada = store.Iniciado;
  const PaginasPublicas = ['/access', '/login', '/register', '/'];
  const EsPaginaPublica = PaginasPublicas.includes(to.path);

  if( (to.path === '/login' || to.path === '/register' || to.path === '/access') && SessionIniciada){
    next('/home');
  }

  if (!SessionIniciada && !EsPaginaPublica) {
    next('/login');
  } else if (SessionIniciada && to.path === '/') {
    next('/home'); // Solo redirige a /home si intentas acceder al landing estando logueado
  } else {
    next(); // Permite la navegación a cualquier otra ruta
  }
});


export default router;