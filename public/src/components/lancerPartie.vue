<template>

  <div>

    <nav-bar></nav-bar>

    <section class="section coop-accueil">

      <div class="panel">

        <p class="panel-heading">

          <div class="navbar-item">
            <router-link class="navbar-item" to="/members">Membres</router-link>
          </div>

        </p>

      </div>
    </section>

  </div>

</template>

<script>

import NavBar from './navBar.vue'

export default {
  name: 'lancerPartie',
  components: {NavBar},
  data () {
    return {
    }
  },
  mounted() {


  }
}
</script>
