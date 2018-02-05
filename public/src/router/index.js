import Vue from 'vue'
import Router from 'vue-router'
import lancerPartie from '@/components/lancerPartie'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      component: lancerPartie
    },
    { path: '*', component: lancerPartie}
  ]
})
