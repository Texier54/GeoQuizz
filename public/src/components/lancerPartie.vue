<template>

  <div>

    <nav-bar></nav-bar>

    <section class="section coop-accueil">

      <nav class="panel">

        <p class="panel-heading">
          Bienvenue sur GeoQuizz !!!!
        </p>

        <div class="panel-block">
          <p class="control has-icons-left">
            Pour lancer une partie, cliquez sur le bouton "Lancer partie" #con
          </p>
        </div>

          <div class="navbar-item">
            <button class="button is-primary" @click="lancerPartie">Lancer partie</button>
          </div>

      </nav>
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

<style scoped>


</style>