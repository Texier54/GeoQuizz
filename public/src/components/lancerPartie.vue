<template>

  <div>

    <nav-bar></nav-bar>

    <section class="section coop-accueil">

      <div class="panel">

        <p class="panel-heading">

          <div class="navbar-item">
            <a class="button" @click="lancerPartie">Lancer partie</a>
          </div>

        </p>

      </div>
    </section>



    <div class="modal" v-bind:class="{ 'is-active': lancer }">
      <div class="modal-background" @click="fermer"></div>
      <div class="modal-card">
        <header class="modal-card-head">
          <p class="modal-card-title">Lancer une partie</p>
          <button class="delete" @click="fermer" aria-label="close"></button>
        </header>
        <form action="/partie">
          <section class="modal-card-body">
              <label class="label" id="pseudo">Pseudo</label>
              <input type="text" class="input" id="pseudo" name="pseudo" placeholder="Pseudo">
          </section>
          <footer class="modal-card-foot">
            <input type="submit" class="button is-success" to="/partie">
            <button class="button" @click="fermer">Cancel</button>
          </footer>
        </form>
      </div>
    </div>

  </div>

</template>

<script>

import NavBar from './navBar.vue'

export default {
  name: 'lancerPartie',
  components: {NavBar},
  data () {
    return {
      lancer: false,
    }
  },
  methods : {
    lancerPartie() {
      this.lancer = true;
    },
    fermer() {
      this.lancer = false;
    }

  }
}
</script>
