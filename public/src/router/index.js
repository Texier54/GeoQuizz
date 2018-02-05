import Vue from 'vue'
import Router from 'vue-router'
import lancerPartie from '@/components/lancerPartie'
import partie from '@/components/partie'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: lancerPartie
    },
    {
      path: '/partie',
      component: partie
    },
    { path: '*', component: lancerPartie}
  ]
})
